<div class="space-y-8 rounded-[32px] border border-white/10 bg-slate-950/95 p-8 shadow-[0_30px_80px_-30px_rgba(15,23,42,0.85)]">
    <header class="space-y-4">
        <div>
            <h2 class="text-3xl font-semibold tracking-tight text-white">Reddit post insights</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">Community signals and post engagement presented in the same dashboard experience.</p>
        </div>
    </header>

    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-sm shadow-slate-950/20">
        <form method="GET" class="grid gap-4 sm:grid-cols-[1fr_auto]">
            <label class="sr-only" for="reddit-search">Search Reddit posts</label>
            <input
                id="reddit-search"
                type="text"
                name="search"
                value="{{ $searchreddit }}"
                placeholder="Search Reddit posts..."
                class="min-w-0 rounded-2xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-sm text-white outline-none ring-1 ring-transparent transition focus:border-orange-400 focus:ring-orange-500/20"
            >
            <button class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-red-950/25 transition hover:brightness-110">
                Search
            </button>
        </form>
    </section>

    <div class="grid gap-4">
        @forelse($postsreddit as $post)
            <article class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-sm shadow-slate-950/20 transition hover:border-orange-500/30 hover:bg-slate-900/95">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="space-y-3">
                        <h3 class="text-xl font-semibold text-white">{{ $post['title'] }}</h3>
                        <p class="text-sm text-slate-400">r/{{ $post['subreddit'] }} • by {{ $post['author'] }} • {{ \Carbon\Carbon::parse($post['created'])->diffForHumans() }}</p>
                        <div class="flex flex-wrap gap-3 text-sm text-slate-300">
                            <span class="rounded-full bg-slate-950/70 px-3 py-2">▲ {{ number_format($post['ups']) }}</span>
                            <span class="rounded-full bg-slate-950/70 px-3 py-2">💬 {{ number_format($post['comments']) }}</span>
                            <span class="rounded-full bg-orange-500/10 px-3 py-2 text-orange-300">Engagement {{ $post['engagement'] }}%</span>
                        </div>
                    </div>

                    <a href="/watch_reddit/{{ $post['id'] }}" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-red-950/20 transition hover:brightness-110">
                        View
                    </a>
                </div>
            </article>
        @empty
            <div class="rounded-3xl border border-dashed border-white/10 bg-slate-900/80 p-6 text-center text-sm text-slate-400">
                No posts found for "{{ $searchreddit }}".
            </div>
        @endforelse
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-center">
        @if($before)
            <form method="GET" class="w-full sm:w-auto">
                <input type="hidden" name="search" value="{{ $searchreddit }}">
                <input type="hidden" name="after" value="{{ $before }}">
                <button class="w-full rounded-2xl border border-white/10 bg-slate-900/80 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 sm:w-auto">
                    ← Prev
                </button>
            </form>
        @endif

        @if($after)
            <form method="GET" class="w-full sm:w-auto">
                <input type="hidden" name="search" value="{{ $searchreddit }}">
                <input type="hidden" name="after" value="{{ $after }}">
                <button class="w-full rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 px-5 py-3 text-sm font-semibold text-white transition hover:brightness-110 sm:w-auto">
                    Next →
                </button>
            </form>
        @endif
    </div>

    <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 text-center text-sm text-slate-400">
        Showing {{ number_format(count($posts)) }} posts • Total reported: {{ number_format($totalPosts) }}
    </div>
</div>
