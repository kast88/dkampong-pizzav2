<?php

namespace App\Http\Controllers;

use App\Services\BloggerService;
use Illuminate\Http\Request;

class BloggerController extends Controller
{
    public function index(Request $request, BloggerService $blogger)
    {
        $url = trim($request->get('url', 'https://pizzaioli.blogspot.com/'));
        $pageToken = $request->get('pageToken');
        $tokenHistory = array_values(array_filter(explode(',', $request->get('history', ''))));

        $blog = $blogger->getBlogByUrl($url);
        $blogId = $blog['id'] ?? null;

        abort_unless($blogId, 404, 'Blog not found');

        $response = $blogger->getPostsByBlogId($blogId, [
            'maxResults' => 6,
            'pageToken' => $pageToken,
            'fetchBodies' => true,
        ]);

        $posts = collect($response['items'] ?? []);
        $nextPageToken = $response['nextPageToken'] ?? null;

        $previousToken = null;
        $previousHistory = $tokenHistory;

        if (!empty($tokenHistory)) {
            $previousToken = array_pop($previousHistory);
        }

        $nextHistory = $tokenHistory;
        if ($pageToken) {
            $nextHistory[] = $pageToken;
        }

        return view('blog.index', [
            'blog' => $blog,
            'posts' => $posts,
            'nextPageToken' => $nextPageToken,
            'previousToken' => $previousToken,
            'nextHistory' => implode(',', $nextHistory),
            'previousHistory' => implode(',', $previousHistory),
            'currentUrl' => $url,
        ]);
    }
}