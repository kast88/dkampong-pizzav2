<div class="space-y-8 rounded-[32px] border border-white/10 bg-slate-950/95 p-8 shadow-[0_30px_80px_-30px_rgba(15,23,42,0.85)]">
    <header class="space-y-4">

        <div>
            <h2 class="text-3xl font-semibold tracking-tight text-white">Pizza video search performance</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">Minimal analytics for pizza video search, presented with calm spacing and focused clarity.</p>
        </div>
    </header>

    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-sm shadow-slate-950/20">
        <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <p class="text-sm text-slate-300">
                Search results for <span class="font-semibold text-white">{{ $search }}</span> • Total videos: <span class="font-semibold text-white">{{ number_format($totalVideos) }}</span>
            </p>
            <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <label class="sr-only" for="youtube-search">Search pizza videos</label>
                <input
                    id="youtube-search"
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search pizza videos..."
                    class="min-w-0 flex-1 rounded-2xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-sm text-white outline-none ring-1 ring-transparent transition focus:border-red-400 focus:ring-red-500/20"
                >
                <button class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-red-950/25 transition hover:brightness-110">
                    Search
                </button>
            </form>
        </div>
    </section>

    @if($isLoggedIn)
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-sm shadow-slate-950/20">
            <p class="text-sm text-slate-400">Total videos found</p>
            <h3 class="mt-3 text-3xl font-semibold text-white">{{ number_format($totalVideos) }}</h3>
        </div>

        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-sm shadow-slate-950/20">
            <p class="text-sm text-slate-400">Platform insight mode</p>
            <h3 class="mt-3 text-3xl font-semibold text-white">{{ $platform }}</h3>
        </div>

        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-sm shadow-slate-950/20">
            <p class="text-sm text-slate-400">Average like-to-view ratio</p>
            <h3 class="mt-3 text-3xl font-semibold text-white">{{ round($averageLikeRatio, 2) }}%</h3>
        </div>

        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-sm shadow-slate-950/20">
            <p class="text-sm text-slate-400">Navigation state</p>
            <h3 class="mt-3 text-3xl font-semibold text-white">{{ $nextPageToken ? 'More available' : 'Last page' }}</h3>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-2">
        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-sm shadow-slate-950/20">
            <h3 class="text-lg font-semibold text-white">Video engagement preview</h3>
            <div class="mt-5 h-60 rounded-3xl bg-slate-950/60 p-4">
                <canvas id="engagementChart" class="h-full w-full"></canvas>
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-sm shadow-slate-950/20">
            <h3 class="text-lg font-semibold text-white">Like ratio trend</h3>
            <div class="mt-5 h-60 rounded-3xl bg-slate-950/60 p-4">
                <canvas id="likeRatioChart" class="h-full w-full"></canvas>
            </div>
        </div>
    </div>
    @endif
    <div class="grid gap-6">
        @foreach($videos as $video)
            @php
                $videoId = $video['id'];
                $title = $video['title'];
                $channel = $video['channel'];
                $views = $video['views'];
                $likes = $video['likes'];
                $commentsCount = $video['comments'];
                $published = $video['published'];
                $isTrending = $video['trending'];
                $engagement = $video['engagement'];
            @endphp

            <article class="overflow-hidden rounded-[32px] border border-white/10 bg-slate-900/80 shadow-xl shadow-slate-950/40">
                <div class="flex flex-col gap-4 border-b border-white/10 p-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-slate-400">{{ $channel }} • {{ \Carbon\Carbon::parse($published)->diffForHumans() }}</p>
                    </div>
                    @if($isTrending)
                        <span class="inline-flex rounded-full bg-red-500/15 px-4 py-2 text-sm font-semibold text-red-200">
                            Trending
                        </span>
                    @endif
                </div>

                <div class="relative overflow-hidden bg-black/90">
                    <div class="aspect-video w-full">
                        <iframe
                            class="h-full w-full"
                            src="https://www.youtube.com/embed/{{ $videoId }}"
                            allowfullscreen
                            loading="lazy"
                            title="{{ $title }}">
                        </iframe>
                    </div>
                </div>

                <div class="flex flex-col gap-4 border-t border-white/10 p-6 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap gap-3 text-sm text-slate-300">
                        <span class="rounded-2xl bg-slate-950/70 px-3 py-2">Views: {{ number_format($views) }}</span>
                        <span class="rounded-2xl bg-slate-950/70 px-3 py-2">Likes: {{ number_format($likes) }}</span>
                        <span class="rounded-2xl bg-slate-950/70 px-3 py-2">Comments: {{ number_format($commentsCount) }}</span>
                        <span class="rounded-2xl bg-orange-500/10 px-3 py-2 text-orange-300">Engagement {{ $engagement }}%</span>
                    </div>
                    <a href="/watch_youtube/{{ $videoId }}" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-red-950/20 transition hover:brightness-110">
                        Watch
                    </a>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        @if($prevPageToken)
            <form method="GET" class="min-w-0 flex-1 sm:max-w-xs">
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="pageToken" value="{{ $prevPageToken }}">
                <button class="w-full rounded-2xl border border-white/10 bg-slate-900/80 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Previous
                </button>
            </form>
        @endif

        @if($nextPageToken)
            <form method="GET" class="min-w-0 flex-1 sm:max-w-xs">
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="pageToken" value="{{ $nextPageToken }}">
                <button class="w-full rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 px-5 py-3 text-sm font-semibold text-white transition hover:brightness-110">
                    Next
                </button>
            </form>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($chartLabels);
    const engagementData = @json($chartEngagement);
    const likeRatioData = @json($chartLikeRatio);

    if (labels.length > 0) {
        new Chart(document.getElementById('engagementChart'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Engagement %',
                    data: engagementData,
                    borderColor: '#f97316', // Orange
                    backgroundColor: 'rgba(249, 115, 22, 0.15)',
                    borderWidth: 4,
                    pointBackgroundColor: '#f97316',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: { ticks: { color: '#cbd5e1' }, grid: { color: '#334155' } },
                    y: { ticks: { color: '#cbd5e1' }, grid: { color: '#334155' } },
                },
            },
        });

        new Chart(document.getElementById('likeRatioChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Like ratio %',
                    data: likeRatioData,
                    backgroundColor: '#2563eb',
                    borderRadius: 8,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: { ticks: { color: '#cbd5e1' }, grid: { color: '#334155' } },
                    y: { ticks: { color: '#cbd5e1' }, grid: { color: '#334155' } },
                },
            },
        });
    }
</script>
