<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LandingPageController extends Controller
{
    public function index()
    {
        $youtubeVideos = Cache::remember('youtube_pizza_full_3', now()->addHours(6), function () {

            $apiKey = env('YOUTUBE_API_KEY');

            // STEP 1: SEARCH VIDEOS (get IDs)
            $searchResponse = Http::get('https://www.googleapis.com/youtube/v3/search', [
                'part' => 'snippet',
                'q' => 'pizza kampung malaysia',
                'type' => 'video',
                'maxResults' => 3,
                'order' => 'relevance',
                'key' => $apiKey,
            ]);

            if (!$searchResponse->successful()) {
                return [];
            }

            $videoIds = collect($searchResponse->json('items'))
                ->pluck('id.videoId')
                ->filter()
                ->implode(',');

            if (!$videoIds) {
                return [];
            }

            // STEP 2: GET STATS (likes/views/comments)
            $videoResponse = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                'part' => 'snippet,statistics,contentDetails',
                'id' => $videoIds,
                'key' => $apiKey,
            ]);

            if (!$videoResponse->successful()) {
                return [];
            }

            return collect($videoResponse->json('items'))->map(function ($video) {

                return [
                    'id' => $video['id'],

                    'title' => $video['snippet']['title'],

                    'channel' => $video['snippet']['channelTitle'],

                    // 🔥 real YouTube thumbnail (best quality)
                    'thumbnail' =>
                        $video['snippet']['thumbnails']['maxres']['url']
                        ?? $video['snippet']['thumbnails']['standard']['url']
                        ?? $video['snippet']['thumbnails']['high']['url']
                        ?? $video['snippet']['thumbnails']['medium']['url']
                        ?? '',

                    // 🔥 stats
                    'views' => $video['statistics']['viewCount'] ?? 0,
                    'likes' => $video['statistics']['likeCount'] ?? null,
                    'comments' => $video['statistics']['commentCount'] ?? 0,

                    // optional YouTube link
                    'url' => 'https://www.youtube.com/watch?v=' . $video['id'],
                ];

            })->values()->toArray();
        });

        $redditReviews = [
            [
                'user' => 'khxirvl',
                'title' => 'Good handmade pizza @ Pizza Mansion PJ',
                'text' => 'Been eating here for 2-3 years.',
                'upvotes' => 89,
                'comments' => 22,
                'url' => 'https://www.reddit.com/r/MalaysianFood/comments/1arax06/good_handmade_pizza_pizza_mansion_pj/',
            ],
            [
                'user' => 'joeboaa',
                'title' => 'Good pizza in Sepang',
                'text' => 'Local Malaysian twist hits different 🔥',
                'upvotes' => 3,
                'comments' => 2,
                'url' => 'https://www.reddit.com/r/MalaysianFood/comments/1keev6t/good_pizza_in_sepang/',
            ],
            [
                'user' => 'The_Chuckness88',
                'title' => 'Nice pizza in Johor but too oily.',
                'text' => null,
                'upvotes' => 851,
                'comments' => 56,
                'url' => 'https://www.reddit.com/r/malaysia/comments/1fx73im/nice_pizza_in_johor_but_too_oily/',
            ],
            [
                'user' => 'xiang2x',
                'title' => 'I somehow manage to find a place that serves Deep Dish Pizza',
                'text' => 'It’s was rather nice. Abit jelak if shared between two. Mean Mince is the name of the shop.',
                'upvotes' => 210,
                'comments' => 31,
                'url' => 'https://www.reddit.com/r/MalaysianFood/comments/1j3zfp1/i_somehow_manage_to_find_a_place_that_serves_deep/',
            ],
        ];

        $products = Product::where('is_active', true)->get();
        $categories = $products->pluck('category')->unique()->filter();

        return view('landing', compact('youtubeVideos', 'redditReviews', 'products', 'categories'));
    }
}
