<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class RedditService
{
    public function search(string $search = 'pizza', ?string $after = null): array
    {
        $response = $this->get($this->endpoint('/search'), [
            'q' => $search,
            'limit' => 12,
            'after' => $after,
            'raw_json' => 1,
        ]);

        if (!$response->successful()) {
            Log::warning('Reddit search request failed.', [
                'status' => $response->status(),
                'body' => Str::limit($response->body(), 500),
            ]);

            return $this->emptySearchResult($search, 'Unable to load Reddit posts right now.');
        }

        $data = $response->json();
        $children = $data['data']['children'] ?? [];

        if (empty($children)) {
            return $this->emptySearchResult($search);
        }

        $postsData = [];
        $postStats = [];

        foreach ($children as $child) {
            $item = $child['data'] ?? null;

            if (!$item) {
                continue;
            }

            $id = $item['id'] ?? null;

            if (!$id) {
                continue;
            }

            $ups = (int) ($item['ups'] ?? 0);
            $comments = (int) ($item['num_comments'] ?? 0);
            $engagement = $ups > 0 ? round(($comments / $ups) * 100, 2) : 0;

            $postStats[$id] = $item;
            $postsData[] = [
                'id' => $id,
                'title' => $item['title'] ?? 'Post',
                'subreddit' => $item['subreddit'] ?? '',
                'author' => $item['author'] ?? '',
                'created' => isset($item['created_utc']) ? date('c', (int) $item['created_utc']) : now()->toIso8601String(),
                'ups' => $ups,
                'comments' => $comments,
                'engagement' => $engagement,
                'url' => $item['permalink'] ?? null,
            ];
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
            'chartLabels' => collect($sorted)->map(fn ($post) => substr($post['title'], 0, 20) . '...')->all(),
            'chartUps' => collect($sorted)->pluck('ups')->all(),
            'chartComments' => collect($sorted)->pluck('comments')->all(),
            'chartEngagement' => collect($sorted)->pluck('engagement')->all(),
            'error' => null,
        ];
    }

    public function comments(string $id): array
    {
        $response = $this->get($this->endpoint("/comments/{$id}"), [
            'limit' => 100,
            'raw_json' => 1,
        ]);

        if (!$response->successful()) {
            Log::warning('Reddit comments request failed.', [
                'id' => $id,
                'status' => $response->status(),
                'body' => Str::limit($response->body(), 500),
            ]);

            return [
                'post' => null,
                'comments' => [],
                'error' => 'Unable to load Reddit comments right now.',
            ];
        }

        $data = $response->json();

        return [
            'post' => $data[0]['data']['children'][0]['data'] ?? null,
            'comments' => $data[1]['data']['children'] ?? [],
            'error' => null,
        ];
    }

    private function get(string $url, array $query)
    {
        $client = $this->baseClient();

        if ($this->hasOauthCredentials()) {
            $token = $this->accessToken();

            if ($token) {
                $client = $client->withToken($token);
            }
        }

        return $client->get($url, $query);
    }

    private function endpoint(string $path): string
    {
        $path = ltrim($path, '/');

        if ($this->hasOauthCredentials()) {
            return "https://oauth.reddit.com/{$path}";
        }

        return "https://www.reddit.com/{$path}.json";
    }

    private function baseClient()
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
            'User-Agent' => config('services.reddit.user_agent'),
        ])->timeout(15);
    }

    private function accessToken(): ?string
    {
        return Cache::remember('reddit.access_token', now()->addMinutes(50), function () {
            $response = $this->baseClient()
                ->asForm()
                ->withBasicAuth(config('services.reddit.client_id'), config('services.reddit.client_secret'))
                ->post('https://www.reddit.com/api/v1/access_token', [
                    'grant_type' => 'client_credentials',
                ]);

            if (!$response->successful()) {
                Log::warning('Reddit access token request failed.', [
                    'status' => $response->status(),
                    'body' => Str::limit($response->body(), 500),
                ]);

                return null;
            }

            return $response->json('access_token');
        });
    }

    private function hasOauthCredentials(): bool
    {
        return filled(config('services.reddit.client_id')) && filled(config('services.reddit.client_secret'));
    }

    private function emptySearchResult(string $search, ?string $error = null): array
    {
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
            'error' => $error,
        ];
    }
}
