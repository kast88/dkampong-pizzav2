<?php

namespace App\Http\Controllers;

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
                'user' => 'foodie_my',
                'title' => 'Best Kampung Pizza in Malaysia',
                'text' => 'Crazy good sambal pizza, unexpected but amazing.',
                'upvotes' => 120,
                'comments' => 22,
            ],
            [
                'user' => 'jalanjalan99',
                'title' => 'Hidden gem pizza spot',
                'text' => 'Local Malaysian twist hits different 🔥',
                'upvotes' => 89,
                'comments' => 14,
            ],
            [
                'user' => 'pizzalover88',
                'title' => 'Worth trying?',
                'text' => 'Yes. Especially cheese + sambal combo.',
                'upvotes' => 54,
                'comments' => 8,
            ],
            [
                'user' => 'makanhunter',
                'title' => 'Unexpectedly good fusion',
                'text' => 'Kampung pizza actually works really well.',
                'upvotes' => 210,
                'comments' => 31,
            ],
        ];

        return view('landing', compact('youtubeVideos', 'redditReviews'));
    }
}
