<?php

namespace App\Http\Controllers;

use App\Enums\LoginProvider;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Services\BloggerService;
// use App\Support\SessionUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Invalid credentials'
            ]);
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Account not found or disabled.'
            ]);
        }

        $remember = $request->boolean('remember');

        Auth::login($user, $remember);

        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('landing');
    }

    public function dashboard(BloggerService $blogger)
    {
        $apiKey = env('YOUTUBE_API_KEY');
        $youtubeVideos = collect([]);
        $redditPost = null;
        $redditComments = [];
        $blog = [];
        $blogPosts = collect([]);

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('landing');
        }

        try {
            $blogUrl = 'https://dkampong-pizza.blogspot.com/';
            $blog = $blogger->getBlogByUrl($blogUrl);
            $blogId = $blog['id'] ?? null;

            if ($blogId) {
                $postResponse = $blogger->getPostsByBlogId($blogId, [
                    'maxResults' => 6,
                    'fetchBodies' => true,
                ]);
                $blogPosts = collect($postResponse['items'] ?? []);
            }
        } catch (\Exception $e) {
            Log::error('Blogger API exception: ' . $e->getMessage());
        }

        $getYouTubeData = $this->getYouTubeData();
        $getRedditData = $this->getRedditData();

        return view('dashboard', [
            // 'user' => SessionUser::get(),
            'youtubeVideos' => $youtubeVideos,
            'redditPost' => $redditPost ?? [],
            'redditComments' => $redditComments,
            'blog' => $blog,
            'posts' => $blogPosts,
            //youtube
            'videos' => $getYouTubeData['videos'],
            'videoStats' => $getYouTubeData['videoStats'] ?? [],
            'search' => $getYouTubeData['search'],
            'platform' => $getYouTubeData['platform'],
            'totalVideos' => $getYouTubeData['totalVideos'] ?? 0,
            'nextPageToken' => $getYouTubeData['nextPageToken'] ?? null,
            'prevPageToken' => $getYouTubeData['prevPageToken'] ?? null,
            'chartLabels' => $getYouTubeData['chartLabels'] ?? [],
            'chartViews' => $getYouTubeData['chartViews'] ?? [],
            'chartLikes' => $getYouTubeData['chartLikes'] ?? [],
            'chartComments' => $getYouTubeData['chartComments'] ?? [],
            'chartEngagement' => $getYouTubeData['chartEngagement'] ?? [],
            'chartLikeRatio' => $getYouTubeData['chartLikeRatio'] ?? [],
            'averageLikeRatio' => round($getYouTubeData['averageLikeRatio'] ?? 0, 2),
            //reddit
            'postsreddit' => $getRedditData['posts'] ?? [],
            'postStats' => $getRedditData['postStats'] ?? [],
            'searchreddit' => $getRedditData['search'] ?? [],
            'platformreddit' => $getRedditData['platform'] ?? 'Reddit',
            'totalPosts' => $getRedditData['totalPosts'] ?? 0,
            'after' => $getRedditData['after'] ?? null,
            'before' => $getRedditData['before'] ?? null,

            'chartLabelsreddit' => $getRedditData['chartLabels'] ?? [],
            'chartUps' => $getRedditData['chartUps'] ?? [],
            'chartCommentsreddit' => $getRedditData['chartComments'] ?? [],
            'chartEngagementreddit' => $getRedditData['chartEngagement'] ?? [],
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }

        public function getYouTubeData()
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

        // VIDEO IDS
        $videoIds = collect($videos)
            ->map(function($video){
                return $video['id']['videoId'] ?? null;
            })
            ->filter()
            ->values()
            ->implode(',');

        if(empty($videoIds)){

            return [
                'videos' => [],
                'videoStats' => [],
                'search' => $search,
                'platform' => 'YouTube',
                'totalVideos' => 0,
                'nextPageToken' => null,
                'prevPageToken' => null,

                'chartLabels' => [],
                'chartViews' => [],
                'chartLikes' => [],
                'chartComments' => [],
                'chartEngagement' => [],
                'chartLikeRatio' => [],
                'averageLikeRatio' => 0,
            ];
        }

        // VIDEO STATS
        $statsResponse = Http::get('https://www.googleapis.com/youtube/v3/videos', [
            'part' => 'statistics,snippet',
            'id' => $videoIds,
            'key' => $apiKey
        ]);

        $statsData = $statsResponse->json()['items'] ?? [];

        $videoStats = [];

        // CHART DATA
        $chartLabels = [];
        $chartViews = [];
        $chartLikes = [];
        $chartComments = [];
        $chartEngagement = [];
        $chartLikeRatio = [];

        $videosData = [];

        foreach ($statsData as $item) {

            if (
                !isset($item['statistics']['viewCount']) ||
                !isset($item['statistics']['likeCount']) ||
                !isset($item['statistics']['commentCount'])
            ) {
                continue;
            }

            $videoStats[$item['id']] = $item; // ✅ IMPORTANT FIX

            $views = (int) $item['statistics']['viewCount'];
            $likes = (int) $item['statistics']['likeCount'];
            $comments = (int) $item['statistics']['commentCount'];

            $engagement = $views > 0
                ? round((($likes + $comments) / $views) * 100, 2)
                : 0;

            $likeRatio = $views > 0
                ? round(($likes / $views) * 100, 2)
                : 0;

            $videosData[] = [
                'id' => $item['id'],
                'title' => $item['snippet']['title'] ?? 'Video',
                'channel' => $item['snippet']['channelTitle'] ?? '',
                'published' => $item['snippet']['publishedAt'] ?? null,
                'views' => $views,
                'likes' => $likes,
                'comments' => $comments,
                'engagement' => $engagement,
                'likeRatio' => $likeRatio,
                'trending' => $views >= 100000
            ];
        }

        foreach ($videosData as $video) {

            $chartLabels[] = substr($video['title'], 0, 20) . '...';
            $chartViews[] = $video['views'];
            $chartLikes[] = $video['likes'];
            $chartComments[] = $video['comments'];
            $chartEngagement[] = $video['engagement'];
            $chartLikeRatio[] = $video['likeRatio'];
        }

        $sortedVideos = collect($videosData)
            ->sortByDesc('views')
            ->values()
            ->all();

        $averageLikeRatio = collect($videosData)->avg('likeRatio');

        return [
            'videos' => $sortedVideos,
            'videoStats' => $videoStats,
            'search' => $search,
            'platform' => 'YouTube',
            'totalVideos' => $data['pageInfo']['totalResults'] ?? 0,
            'nextPageToken' => $data['nextPageToken'] ?? null,
            'prevPageToken' => $data['prevPageToken'] ?? null,

            'chartLabels' => $chartLabels,
            'chartViews' => $chartViews,
            'chartLikes' => $chartLikes,
            'chartComments' => $chartComments,
            'chartEngagement' => $chartEngagement,
            'chartLikeRatio' => $chartLikeRatio,
            'averageLikeRatio' => round($averageLikeRatio, 2),
        ];
    }

    public function getRedditData()
    {
        $search = request('search', 'pizza');

        $after = request('after');

        $response = Http::get('https://www.reddit.com/search.json', [
            'q' => $search,
            'limit' => 12,
            'after' => $after,
        ]);

        $data = $response->json();

        $children = $data['data']['children'] ?? [];

        if (empty($children)) {
            return [
                'posts' => [],
                'postStats' => [],
                'search' => $search,
                'platform' => 'Reddit',
                'totalPosts' => 0,
                'after' => null,
                'before' => null,

                'chartLabels' => [],
                'chartUps' => [],
                'chartComments' => [],
                'chartEngagement' => [],
            ];
        }

        $postsData = [];
        $postStats = [];

        $chartLabels = [];
        $chartUps = [];
        $chartComments = [];
        $chartEngagement = [];

        foreach ($children as $child) {
            $item = $child['data'] ?? null;
            if (!$item) {
                continue;
            }

            $id = $item['id'] ?? null;
            $title = $item['title'] ?? 'Post';
            $ups = (int) ($item['ups'] ?? 0);
            $num_comments = (int) ($item['num_comments'] ?? 0);

            $engagement = $ups > 0 ? round(($num_comments / $ups) * 100, 2) : 0;

            if ($id) {
                $postStats[$id] = $item;

                $postsData[] = [
                    'id' => $id,
                    'title' => $title,
                    'subreddit' => $item['subreddit'] ?? '',
                    'author' => $item['author'] ?? '',
                    'created' => isset($item['created_utc']) ? date('c', $item['created_utc']) : null,
                    'ups' => $ups,
                    'comments' => $num_comments,
                    'engagement' => $engagement,
                    'url' => $item['permalink'] ?? null,
                ];
            }
        }

        foreach ($postsData as $p) {
            $chartLabels[] = substr($p['title'], 0, 20) . '...';
            $chartUps[] = $p['ups'];
            $chartComments[] = $p['comments'];
            $chartEngagement[] = $p['engagement'];
        }

        $sorted = collect($postsData)
            ->sortByDesc('ups')
            ->values()
            ->all();

        return [
            'posts' => $sorted,
            'postStats' => $postStats,
            'search' => $search,
            'platform' => 'Reddit',
            'totalPosts' => $data['data']['dist'] ?? count($children),
            'after' => $data['data']['after'] ?? null,
            'before' => $data['data']['before'] ?? null,

            'chartLabels' => $chartLabels,
            'chartUps' => $chartUps,
            'chartComments' => $chartComments,
            'chartEngagement' => $chartEngagement,
        ];
    }

    public function showRegister(): \Illuminate\View\View
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'is_active' => true,
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Account created successfully. Please login.');
    }
}
