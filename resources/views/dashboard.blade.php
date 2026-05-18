@extends('layouts.app', ['title' => "D'Kampong Dashboard"])

@section('content')
@php
    $name = $user['name'] ?? 'Admin';
    $youtubeSnippet = $youtubeVideo['snippet'] ?? [];
    $youtubeStats = $youtubeVideo['statistics'] ?? [];

    $ytTitle = $youtubeSnippet['title'] ?? 'No YouTube video loaded';
    $ytChannel = $youtubeSnippet['channelTitle'] ?? 'Unknown Channel';
    $ytViews = (int) ($youtubeStats['viewCount'] ?? 0);
    $ytLikes = (int) ($youtubeStats['likeCount'] ?? 0);
    $ytCommentsTotal = (int) ($youtubeStats['commentCount'] ?? 0);
    $ytPublished = $youtubeSnippet['publishedAt'] ?? null;

    $redditTitle = $redditPost['title'] ?? 'No Reddit post loaded';
    $redditSubreddit = $redditPost['subreddit'] ?? 'Unknown subreddit';
    $redditAuthor = $redditPost['author'] ?? 'Unknown author';
    $redditUps = (int) ($redditPost['ups'] ?? 0);
    $redditCommentsTotal = (int) ($redditPost['comments'] ?? count($redditComments ?? []));
    $redditUrl = isset($redditPost['url']) ? 'https://reddit.com' . $redditPost['url'] : '#';

    $youtubeComments = $youtubeComments ?? [];
    $redditComments = $redditComments ?? [];

    $ytEngagement = $ytViews > 0 ? round((($ytLikes + $ytCommentsTotal) / $ytViews) * 100, 2) : 0;

    $redditCommentBodies = collect($redditComments)
        ->map(fn ($c) => $c['data']['body'] ?? null)
        ->filter()
        ->values();

    $redditAvgCommentLength = $redditCommentBodies->count() > 0
        ? round($redditCommentBodies->map(fn ($text) => mb_strlen(strip_tags($text)))->avg(), 0)
        : 0;

    $ytChartLabels = ['Views', 'Likes', 'Comments'];
    $ytChartValues = [$ytViews, $ytLikes, $ytCommentsTotal];

    $redditChartLabels = ['Upvotes', 'Comments', 'Avg Comment Length'];
    $redditChartValues = [$redditUps, $redditCommentsTotal, $redditAvgCommentLength];
@endphp

<div class="min-h-screen bg-zinc-950 text-zinc-100">
    <div class="flex min-h-screen">
        <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">
            <div class="border-b border-white/10 px-6 py-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-orange-500 to-red-600 text-lg font-black text-white shadow-lg shadow-red-900/30">
                        DK
                    </div>
                    <div>
                        <p class="text-lg font-bold tracking-wide">D'Kampong</p>
                        <p class="text-sm text-zinc-400">Media Analytics</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 space-y-2 px-4 py-6 text-sm">
                <a href="#" class="flex items-center gap-3 rounded-xl bg-gradient-to-r from-orange-500/20 to-red-500/20 px-4 py-3 font-medium text-white ring-1 ring-orange-500/30">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-zinc-300 transition hover:bg-white/5 hover:text-white">
                    <span>▶️</span>
                    <span>YouTube Watch</span>
                </a>
                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-zinc-300 transition hover:bg-white/5 hover:text-white">
                    <span>🧡</span>
                    <span>Reddit Watch</span>
                </a>
            </nav>

            <div class="border-t border-white/10 p-4">
                <div class="rounded-2xl bg-gradient-to-br from-zinc-900 to-zinc-800 p-4 ring-1 ring-white/10">
                    <p class="text-sm text-zinc-400">Logged in as</p>
                    <p class="mt-1 font-semibold text-white">{{ $name }}</p>
                    <p class="text-sm text-zinc-500">{{ $user['email'] ?? 'admin@dkampong.com' }}</p>
                </div>
            </div>
        </aside>

        <main class="flex-1">
            <header class="border-b border-white/10 bg-zinc-950/80 px-6 py-5 backdrop-blur">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-orange-400">D'Kampong Analytics</p>
                        <h1 class="mt-1 text-3xl font-bold text-white">YouTube & Reddit Dashboard</h1>
                        <p class="mt-1 text-sm text-zinc-400">Track social engagement and community response in one place.</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-xl bg-gradient-to-r from-red-500 to-orange-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-red-950/30 transition hover:opacity-90">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <div class="space-y-6 p-6">
                <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-3xl border border-orange-500/20 bg-gradient-to-br from-orange-500/15 to-red-500/10 p-5">
                        <p class="text-sm text-zinc-300">YouTube Views</p>
                        <h2 class="mt-3 text-3xl font-bold text-white">{{ number_format($ytViews) }}</h2>
                        <p class="mt-2 text-sm text-zinc-400">{{ $ytChannel }}</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-sm text-zinc-400">YouTube Engagement</p>
                        <h2 class="mt-3 text-3xl font-bold text-white">{{ $ytEngagement }}%</h2>
                        <p class="mt-2 text-sm text-zinc-400">{{ number_format($ytLikes) }} likes + {{ number_format($ytCommentsTotal) }} comments</p>
                    </div>

                    <div class="rounded-3xl border border-red-500/20 bg-red-500/10 p-5">
                        <p class="text-sm text-zinc-300">Reddit Upvotes</p>
                        <h2 class="mt-3 text-3xl font-bold text-white">{{ number_format($redditUps) }}</h2>
                        <p class="mt-2 text-sm text-zinc-400">r/{{ $redditSubreddit }}</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-sm text-zinc-400">Avg Reddit Comment Length</p>
                        <h2 class="mt-3 text-3xl font-bold text-white">{{ number_format($redditAvgCommentLength) }}</h2>
                        <p class="mt-2 text-sm text-zinc-400">{{ number_format($redditCommentsTotal) }} comments analysed</p>
                    </div>
                </section>

                <section class="grid gap-6 xl:grid-cols-2">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                        <div class="mb-5">
                            <h3 class="text-xl font-semibold text-white">YouTube Analytics</h3>
                            <p class="text-sm text-zinc-400">Views, likes, and comments from the selected video</p>
                        </div>
                        <div class="h-80">
                            <canvas id="youtubeChart"></canvas>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                        <div class="mb-5">
                            <h3 class="text-xl font-semibold text-white">Reddit Analytics</h3>
                            <p class="text-sm text-zinc-400">Upvotes, comments, and average comment length</p>
                        </div>
                        <div class="h-80">
                            <canvas id="redditChart"></canvas>
                        </div>
                    </div>
                </section>

                <section class="rounded-3xl border border-white/10 bg-white/5 p-3">
                    <div class="flex flex-wrap gap-3">
                        <button type="button" class="media-tab-btn rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 px-5 py-3 text-sm font-semibold text-white" data-tab="youtube">
                            YouTube
                        </button>
                        <button type="button" class="media-tab-btn rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-zinc-200" data-tab="reddit">
                            Reddit
                        </button>
                    </div>
                </section>

                <section id="tab-youtube" class="media-tab-panel space-y-6">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                            <div>
                                <p class="text-sm uppercase tracking-wide text-orange-400">YouTube Video</p>
                                <h2 class="mt-2 text-2xl font-bold text-white">{{ $ytTitle }}</h2>
                                <div class="mt-3 flex flex-wrap gap-4 text-sm text-zinc-400">
                                    <span>Channel: {{ $ytChannel }}</span>
                                    <span>Views: {{ number_format($ytViews) }}</span>
                                    <span>Likes: {{ number_format($ytLikes) }}</span>
                                    <span>Comments: {{ number_format($ytCommentsTotal) }}</span>
                                </div>
                            </div>

                            @if(!empty($youtubeVideo['id']))
                                <a href="https://youtube.com/watch?v={{ $youtubeVideo['id'] }}" target="_blank" class="rounded-2xl bg-red-500 px-4 py-3 text-sm font-semibold text-white hover:bg-red-600">
                                    Open in YouTube
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-white">YouTube Comments</h3>
                            <span class="rounded-full bg-orange-500/15 px-3 py-1 text-xs text-orange-300">{{ number_format($ytCommentsTotal) }}</span>
                        </div>

                        <div class="space-y-4">
                            @forelse($youtubeComments as $comment)
                                @php
                                    $snippet = $comment['snippet']['topLevelComment']['snippet'] ?? [];
                                    $author = $snippet['authorDisplayName'] ?? 'Unknown User';
                                    $text = $snippet['textDisplay'] ?? '';
                                @endphp

                                <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                                    <p class="font-semibold text-white">{{ $author }}</p>
                                    <div class="mt-2 text-sm leading-7 text-zinc-300">{!! $text !!}</div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-white/10 bg-black/20 p-6 text-sm text-zinc-400">
                                    No YouTube comments available.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section id="tab-reddit" class="media-tab-panel hidden space-y-6">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                            <div>
                                <p class="text-sm uppercase tracking-wide text-red-400">Reddit Post</p>
                                <h2 class="mt-2 text-2xl font-bold text-white">{{ $redditTitle }}</h2>
                                <div class="mt-3 flex flex-wrap gap-4 text-sm text-zinc-400">
                                    <span>Subreddit: r/{{ $redditSubreddit }}</span>
                                    <span>Author: {{ $redditAuthor }}</span>
                                    <span>Upvotes: {{ number_format($redditUps) }}</span>
                                    <span>Comments: {{ number_format($redditCommentsTotal) }}</span>
                                </div>
                            </div>

                            <a href="{{ $redditUrl }}" target="_blank" class="rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white hover:bg-orange-600">
                                Open in Reddit
                            </a>
                        </div>

                        @if(!empty($redditPost['selftext']))
                            <div class="mt-5 rounded-2xl border border-white/10 bg-black/20 p-4 text-sm leading-7 text-zinc-300 whitespace-pre-wrap">
                                {{ $redditPost['selftext'] }}
                            </div>
                        @endif
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-white">Reddit Comments</h3>
                            <span class="rounded-full bg-red-500/15 px-3 py-1 text-xs text-red-300">{{ number_format($redditCommentsTotal) }}</span>
                        </div>

                        <div class="space-y-4">
                            @forelse($redditComments as $comment)
                                @php
                                    $data = $comment['data'] ?? [];
                                    $author = $data['author'] ?? 'Unknown User';
                                    $body = $data['body'] ?? null;
                                @endphp

                                @if($body)
                                    <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                                        <p class="font-semibold text-white">{{ $author }}</p>
                                        <div class="mt-2 whitespace-pre-wrap text-sm leading-7 text-zinc-300">{{ $body }}</div>
                                    </div>
                                @endif
                            @empty
                                <div class="rounded-2xl border border-dashed border-white/10 bg-black/20 p-6 text-sm text-zinc-400">
                                    No Reddit comments available.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const youtubeLabels = @json($ytChartLabels);
    const youtubeValues = @json($ytChartValues);
    const redditLabels = @json($redditChartLabels);
    const redditValues = @json($redditChartValues);

    new Chart(document.getElementById('youtubeChart'), {
        type: 'bar',
        data: {
            labels: youtubeLabels,
            datasets: [{
                label: 'YouTube Metrics',
                data: youtubeValues,
                backgroundColor: ['#f97316', '#ef4444', '#fb923c'],
                borderRadius: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { ticks: { color: '#d4d4d8' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                y: { ticks: { color: '#d4d4d8' }, grid: { color: 'rgba(255,255,255,0.05)' } }
            }
        }
    });

    new Chart(document.getElementById('redditChart'), {
        type: 'line',
        data: {
            labels: redditLabels,
            datasets: [{
                label: 'Reddit Metrics',
                data: redditValues,
                borderColor: '#ef4444',
                backgroundColor: 'rgba(249,115,22,0.2)',
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#f97316',
                pointBorderColor: '#fff',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { ticks: { color: '#d4d4d8' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                y: { ticks: { color: '#d4d4d8' }, grid: { color: 'rgba(255,255,255,0.05)' } }
            }
        }
    });

    const tabButtons = document.querySelectorAll('.media-tab-btn');
    const tabPanels = document.querySelectorAll('.media-tab-panel');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const activeTab = button.dataset.tab;

            tabButtons.forEach(btn => {
                btn.classList.remove('bg-gradient-to-r', 'from-orange-500', 'to-red-500', 'text-white');
                btn.classList.add('border', 'border-white/10', 'bg-white/5', 'text-zinc-200');
            });

            button.classList.remove('border', 'border-white/10', 'bg-white/5', 'text-zinc-200');
            button.classList.add('bg-gradient-to-r', 'from-orange-500', 'to-red-500', 'text-white');

            tabPanels.forEach(panel => panel.classList.add('hidden'));
            document.getElementById(`tab-${activeTab}`).classList.remove('hidden');
        });
    });
</script>
@endsection