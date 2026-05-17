<?php

namespace App\Http\Controllers;

use App\Enums\LoginProvider;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Support\SessionUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        if (SessionUser::check()) {
            return view('dashboard', [
                'user' => SessionUser::get(),
            ]);
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        // Fake login, no DB
        if (
            $credentials['email'] !== 'admin@example.com' ||
            $credentials['password'] !== '123456'
        ) {
            return back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->withInput();
        }

        SessionUser::put([
            'id' => 'USR-1001',
            'name' => 'System Admin',
            'email' => $credentials['email'],
            'role' => UserRole::Admin,
            'provider' => LoginProvider::Local,
        ]);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function dashboard(): View
    {
        $apiKey = env('YOUTUBE_API_KEY');
        $youtubeVideo = null;
        $youtubeComments = [];
        $redditPost = null;
        $redditComments = [];

        // Fetch featured YouTube video
        if ($apiKey) {
            try {
                $response = Http::timeout(10)->get('https://www.googleapis.com/youtube/v3/search', [
                    'part' => 'snippet',
                    'q' => 'pizza',
                    'type' => 'video',
                    'maxResults' => 1,
                    'key' => $apiKey
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $videos = $data['items'] ?? [];

                    if (!empty($videos)) {
                        $videoId = $videos[0]['id']['videoId'] ?? null;

                        if ($videoId) {
                            // Get video stats and details
                            $statsResponse = Http::timeout(10)->get('https://www.googleapis.com/youtube/v3/videos', [
                                'part' => 'statistics,snippet',
                                'id' => $videoId,
                                'key' => $apiKey
                            ]);

                            if ($statsResponse->successful()) {
                                $youtubeVideo = $statsResponse->json()['items'][0] ?? null;

                                // Get comments
                                $commentsResponse = Http::timeout(10)->get('https://www.googleapis.com/youtube/v3/commentThreads', [
                                    'part' => 'snippet',
                                    'videoId' => $videoId,
                                    'maxResults' => 5,
                                    'key' => $apiKey
                                ]);

                                if ($commentsResponse->successful()) {
                                    $youtubeComments = $commentsResponse->json()['items'] ?? [];
                                }
                            }
                        }
                    }
                } else {
                    Log::error('YouTube API error: ' . $response->status() . ' - ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('YouTube API exception: ' . $e->getMessage());
            }
        } else {
            Log::warning('YouTube API key not configured');
        }

        // Fetch featured Reddit post
        try {
            $response = Http::timeout(10)->get('https://www.reddit.com/search.json', [
                'q' => 'pizza',
                'limit' => 5,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $children = $data['data']['children'] ?? [];

                if (!empty($children)) {
                    // Get a random post from results
                    $post = $children[array_rand($children)]['data'] ?? null;

                    if ($post) {
                        $redditPost = $post;

                        // Get comments for this post
                        $postId = $post['id'] ?? null;
                        if ($postId) {
                            $commentsResponse = Http::timeout(10)->get("https://www.reddit.com/comments/{$postId}.json", [
                                'limit' => 10
                            ]);

                            if ($commentsResponse->successful()) {
                                $commentsData = $commentsResponse->json();
                                $redditComments = $commentsData[1]['data']['children'] ?? [];
                            }
                        }
                    }
                }
            } else {
                Log::error('Reddit API error: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Reddit API exception: ' . $e->getMessage());
        }

        return view('dashboard', [
            'user' => SessionUser::get(),
            'youtubeVideo' => $youtubeVideo ?? [],
            'youtubeComments' => $youtubeComments,
            'redditPost' => $redditPost ?? [],
            'redditComments' => $redditComments,
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        SessionUser::logout();

        return redirect()->route('login');
    }
}