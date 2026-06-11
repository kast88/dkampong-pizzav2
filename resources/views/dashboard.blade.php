@extends('layouts.app', ['title' => "D'Kampong Dashboard"])

@section('content')
@php
    $name = $user['name'] ?? 'Admin';

    // YouTube data
    $youtubeVideos = $youtubeVideos ?? collect([]);
    $firstVideo = $youtubeVideos->first();
    $youtubeSnippet = $firstVideo['video']['snippet'] ?? [];
    $youtubeStats = $firstVideo['video']['statistics'] ?? [];

    $ytTitle = $youtubeSnippet['title'] ?? 'No YouTube video loaded';
    $ytChannel = $youtubeSnippet['channelTitle'] ?? 'Unknown Channel';
    $ytViews = (int) ($youtubeStats['viewCount'] ?? 0);
    $ytLikes = (int) ($youtubeStats['likeCount'] ?? 0);
    $ytCommentsTotal = (int) ($youtubeStats['commentCount'] ?? 0);

    // Reddit data
    $redditTitle = $redditPost['title'] ?? 'No Reddit post loaded';
    $redditSubreddit = $redditPost['subreddit'] ?? 'Unknown subreddit';
    $redditAuthor = $redditPost['author'] ?? 'Unknown author';
    $redditUps = (int) ($redditPost['ups'] ?? 0);
    $redditCommentsTotal = (int) ($redditPost['comments'] ?? count($redditComments ?? []));
    $redditUrl = isset($redditPost['url']) ? 'https://reddit.com' . $redditPost['url'] : '#';

    $redditComments = $redditComments ?? [];

    // Blog defaults
    $blog = $blog ?? [];
    $posts = $posts ?? collect([]);

    // Calculate blog statistics
    $blogTotalPosts = $blog['posts']['totalItems'] ?? $posts->count();
    $blogTotalComments = 0;

    foreach ($posts as $post) {
        $blogTotalComments += $post['replies']['totalItems'] ?? 0;
    }

    $blogAvgCommentsPerPost = $posts->count() > 0 ? round($blogTotalComments / $posts->count(), 1) : 0;
    $blogEngagement = $blogTotalPosts > 0 ? round(($blogTotalComments / $blogTotalPosts) * 100, 2) : 0;

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

    // use App\Support\SessionUser;
    // $isLoggedIn = SessionUser::check();
@endphp

<div class="min-h-screen bg-zinc-950 text-zinc-100">
    <div class="flex min-h-screen">
        <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">
            @include('layouts.sidebar')
        </aside>

        <main class="flex-1">
            <header class="border-b border-white/10 bg-zinc-950/80 px-6 py-5 backdrop-blur">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-orange-400">D'Kampong Analytics</p>
                        <h1 class="mt-1 text-3xl font-bold text-white">Social Media Platform Dashboard</h1>
                        <p class="mt-1 text-sm text-zinc-400">Track social engagement and community response in one place.</p>
                    </div>
                    {{-- @if(Auth::check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-xl bg-gradient-to-r from-red-500 to-orange-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-red-950/30 transition hover:opacity-90">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">
                            <button class="rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-950/30 transition hover:opacity-90">
                                Login
                            </button>
                        </a>
                    @endif --}}
                </div>
            </header>

            <div class="space-y-6 p-6">

                <section class="rounded-3xl border border-white/10 bg-white/5 p-3">
                    <div class="flex flex-wrap gap-3">
                        <button type="button" class="media-tab-btn rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 px-5 py-3 text-sm font-semibold text-white" data-tab="youtube">
                            ▶️ YouTube
                        </button>
                        {{-- <button type="button" class="media-tab-btn rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-zinc-200 hover:bg-white/10" data-tab="reddit">
                            🧡 Reddit
                        </button> --}}
                        <button type="button" class="media-tab-btn rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-zinc-200 hover:bg-white/10" data-tab="blog">
                            📖 Blog
                        </button>
                    </div>
                </section>

                <section id="tab-youtube" class="media-tab-panel space-y-6">
                    @include('youtube_dashboard')
                </section>

                <section id="tab-reddit" class="media-tab-panel hidden space-y-6">
                    @include('reddit_dashboard')
                </section>

                <section id="tab-blog" class="media-tab-panel hidden space-y-6">
                    @if(!empty($blog))
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                            <div>
                                <p class="text-sm uppercase tracking-wide text-orange-400">Blog</p>
                                <h2 class="mt-2 text-2xl font-bold text-white">{{ $blog['name'] ?? 'Blog' }}</h2>
                                <p class="mt-3 max-w-2xl text-sm leading-7 text-zinc-400">{{ $blog['description'] ?? 'A collection of thoughtful posts and stories.' }}</p>
                                @if(!empty($blog['url']))
                                    <a href="{{ $blog['url'] }}" target="_blank" class="mt-4 inline-block rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
                                        Visit Blog
                                    </a>
                                @endif
                            </div>
                        </div>

                        @if(!empty($posts) && $posts->count())
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                                <div class="mb-6 flex items-center justify-between">
                                    <h3 class="text-xl font-semibold text-white">Recent Posts</h3>
                                    <span class="rounded-full bg-orange-500/15 px-3 py-1 text-xs text-orange-300">{{ $posts->count() }} posts</span>
                                </div>

                                <div class="space-y-4">
                                    @foreach($posts as $post)
                                        <div class="group rounded-2xl border border-white/10 bg-black/20 p-5 transition hover:border-orange-500/30 hover:bg-black/30">
                                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-white group-hover:text-orange-300">
                                                        {{ $post['title'] ?? 'Untitled Post' }}
                                                    </h4>
                                                    <p class="mt-2 text-sm text-zinc-400">
                                                        {{ \Illuminate\Support\Str::limit(strip_tags($post['content'] ?? ''), 150) }}
                                                    </p>
                                                    <div class="mt-3 flex flex-wrap gap-2">
                                                        @if(!empty($post['labels']))
                                                            @foreach(array_slice($post['labels'], 0, 3) as $label)
                                                                <span class="rounded-full bg-orange-500/10 px-2 py-1 text-xs text-orange-300">
                                                                    {{ $label }}
                                                                </span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex flex-col items-start gap-2 sm:items-end sm:text-right">
                                                    <span class="text-xs text-zinc-500">
                                                        {{ !empty($post['published']) ? \Carbon\Carbon::parse($post['published'])->format('d M Y') : '-' }}
                                                    </span>
                                                    @if(isset($post['replies']['totalItems']))
                                                        <span class="text-xs text-zinc-400">
                                                            💬 {{ $post['replies']['totalItems'] }} comments
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="rounded-3xl border border-dashed border-white/10 bg-white/5 p-12 text-center">
                                <p class="text-sm text-zinc-400">No blog posts available at this time.</p>
                            </div>
                        @endif
                    @else
                        <div class="rounded-3xl border border-dashed border-white/10 bg-white/5 p-12 text-center">
                            <p class="text-sm text-zinc-400">Blog data not loaded. Please configure your blog settings.</p>
                        </div>
                    @endif
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

    const youtubeChartElement = document.getElementById('youtubeChart');
    const redditChartElement = document.getElementById('redditChart');

    if (youtubeChartElement) {
        new Chart(youtubeChartElement, {
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
    }

    if (redditChartElement) {
        new Chart(redditChartElement, {
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
    }

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
