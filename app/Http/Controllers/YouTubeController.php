<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class YouTubeController extends Controller
{
    public function index()
    {
        // You can reuse same logic as YouTubeController but lighter
        $apiKey = env('YOUTUBE_API_KEY');

        $response = Http::get('https://www.googleapis.com/youtube/v3/search', [
            'part' => 'snippet',
            'q' => 'kampung pizza',
            'type' => 'video',
            'maxResults' => 6,
            'key' => $apiKey,
        ]);

        $videos = $response->json()['items'] ?? [];

        // Convert to simple format for landing page
        $youtubeVideos = collect($videos)->map(function ($video) {
            return [
                'id' => $video['id']['videoId'] ?? null,
                'title' => $video['snippet']['title'] ?? '',
                'thumbnail' => $video['snippet']['thumbnails']['high']['url'] ?? '',
                'channel' => $video['snippet']['channelTitle'] ?? '',
            ];
        })->filter();

        // TEMP: Reddit placeholder (we’ll upgrade later)
        $redditReviews = [
            [
                'user' => 'foodie_my',
                'text' => 'Best kampung-style pizza I’ve tried in Malaysia!',
                'upvotes' => 120
            ],
            [
                'user' => 'jalanjalan99',
                'text' => 'Sambal pizza actually works better than expected 🔥',
                'upvotes' => 89
            ],
        ];

        return view('landing', [
            'youtubeVideos' => $youtubeVideos,
            'redditReviews' => $redditReviews,
        ]);
    }


    public function watch($id)
    {
        $apiKey = env('YOUTUBE_API_KEY');

        $pageToken = request('pageToken');

        // Get comments
        $response = Http::get('https://www.googleapis.com/youtube/v3/commentThreads', [
            'part' => 'snippet',
            'videoId' => $id,
            'maxResults' => 100,
            'pageToken' => $pageToken,
            'key' => $apiKey
        ]);

        $data = $response->json();

        $comments = $data['items'] ?? [];

        // Get video details
        $videoResponse = Http::get('https://www.googleapis.com/youtube/v3/videos', [
            'part' => 'snippet,statistics',
            'id' => $id,
            'key' => $apiKey
        ]);

        $videoData = $videoResponse->json()['items'][0] ?? null;

        return view('watch_youtube', [
            'id' => $id,
            'comments' => $comments,
            'video' => $videoData,
            'nextPageToken' => $data['nextPageToken'] ?? null,
            'prevPageToken' => $data['prevPageToken'] ?? null
        ]);
    }
}
