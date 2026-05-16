<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class RedditController extends Controller
{
    public function index()
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
            return view('reddit', [
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
            ]);
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

        return view('reddit', [
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
        ]);
    }

    public function show($id)
    {
        $response = Http::get("https://www.reddit.com/comments/{$id}.json", [
            'limit' => 100
        ]);

        $data = $response->json();

        $post = $data[0]['data']['children'][0]['data'] ?? null;
        $comments = $data[1]['data']['children'] ?? [];

        return view('watch_reddit', [
            'id' => $id,
            'post' => $post,
            'comments' => $comments,
        ]);
    }
}
