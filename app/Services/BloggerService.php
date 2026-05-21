<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BloggerService
{
    protected string $baseUrl = 'https://www.googleapis.com/blogger/v3';

    public function getBlogByUrl(string $url): array
    {
        return Http::get("{$this->baseUrl}/blogs/byurl", [
            'url' => $url,
            'key' => config('services.blogger.key'),
            'fields' => 'id,name,description,url,posts/totalItems',
        ])->throw()->json();
    }

    public function getPostsByBlogId(string $blogId, array $params = []): array
    {
        $query = array_filter([
            'key' => config('services.blogger.key'),
            'maxResults' => $params['maxResults'] ?? 6,
            'pageToken' => $params['pageToken'] ?? null,
            'fetchBodies' => $params['fetchBodies'] ?? true,
            'status' => 'LIVE',
            'orderBy' => 'published',
            'fields' => 'items(id,title,url,published,labels,content,replies/totalItems),nextPageToken,prevPageToken',
        ], fn ($value) => !is_null($value));

        return Http::get("{$this->baseUrl}/blogs/{$blogId}/posts", $query)
            ->throw()
            ->json();
    }
}