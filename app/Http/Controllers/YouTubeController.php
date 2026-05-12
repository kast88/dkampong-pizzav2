<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class YouTubeController extends Controller
{
    public function index()
    {
        $apiKey = env('YOUTUBE_API_KEY');

        $search = request('search', 'kampung pizza');

        $pageToken = request('pageToken');

        $response = Http::get('https://www.googleapis.com/youtube/v3/search', [
            'part' => 'snippet',
            'q' => $search,
            'type' => 'video',
            'maxResults' => 12,
            'key' => $apiKey,
            'pageToken' => $pageToken
        ]);

        $data = $response->json();

        $videos = $data['items'] ?? [];

        // Extract video IDs
        $videoIds = collect($videos)
            ->pluck('id.videoId')
            ->filter()
            ->implode(',');

        // Get video statistics
        $statsResponse = Http::get('https://www.googleapis.com/youtube/v3/videos', [
            'part' => 'statistics,snippet',
            'id' => $videoIds,
            'key' => $apiKey
        ]);

        $statsData = $statsResponse->json()['items'] ?? [];

        // Map stats by video ID
        $videoStats = [];

        foreach ($statsData as $item) {
            $videoStats[$item['id']] = $item;
        }

        return view('youtube', [
            'videos' => $videos,
            'videoStats' => $videoStats,
            'search' => $search,
            'platform' => 'YouTube',
            'totalVideos' => $data['pageInfo']['totalResults'] ?? 0,
            'nextPageToken' => $data['nextPageToken'] ?? null,
            'prevPageToken' => $data['prevPageToken'] ?? null
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
