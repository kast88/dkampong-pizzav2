<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog['name'] ?? 'Blog' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        cream: '#f8f5f0',
                        sand: '#efe7dc',
                        ink: '#1f2937',
                        mocha: '#6b5b4d',
                        rosebrown: '#b08968',
                    },
                    boxShadow: {
                        soft: '0 10px 30px rgba(15, 23, 42, 0.08)',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-cream via-white to-sand text-ink min-h-screen">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <header class="relative overflow-hidden rounded-[2rem] border border-white/60 bg-white/70 p-8 shadow-soft backdrop-blur-xl sm:p-10 lg:p-14">
            <div class="absolute inset-0 bg-gradient-to-r from-white/40 via-transparent to-rosebrown/10"></div>
            <div class="relative">
                <p class="mb-3 inline-flex rounded-full bg-rosebrown/10 px-4 py-1 text-sm font-medium text-rosebrown">
                    Curated stories & blog updates
                </p>

                <h1 class="font-serif text-4xl font-semibold tracking-tight text-ink sm:text-5xl">
                    {{ $blog['name'] ?? 'My Blog' }}
                </h1>

                <p class="mt-4 max-w-3xl text-base leading-7 text-gray-600 sm:text-lg">
                    {{ $blog['description'] ?? 'A collection of thoughtful posts and stories.' }}
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-3 text-sm text-gray-500">
                    @if(!empty($blog['url']))
                        <!-- <a href="{{ $blog['url'] }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center rounded-full border border-gray-200 bg-white px-4 py-2 transition hover:border-rosebrown hover:text-rosebrown">
                            Visit blog
                        </a> -->
                    @endif

                    <!-- @if(!empty($blog['posts']['totalItems']))
                        <span class="inline-flex items-center rounded-full bg-gray-900 px-4 py-2 text-white">
                            {{ $blog['posts']['totalItems'] }} posts
                        </span>
                    @endif -->
                </div>
            </div>
        </header>

        <section class="mt-10">
            @if($posts->count())
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($posts as $post)
                        <article class="group flex h-full flex-col overflow-hidden rounded-[1.75rem] border border-white/70 bg-white/80 p-6 shadow-soft backdrop-blur-sm transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                            <div class="mb-4 flex items-center justify-between gap-3">
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">
                                    Post
                                </span>

                                <span class="text-sm text-gray-400">
                                    {{ !empty($post['published']) ? \Carbon\Carbon::parse($post['published'])->format('d M Y') : '-' }}
                                </span>
                            </div>

                            <h2 class="font-serif text-2xl leading-tight text-ink transition group-hover:text-rosebrown">
                                <a href="{{ $post['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer">
                                    {{ $post['title'] ?? 'Untitled Post' }}
                                </a>
                            </h2>

                            @if(!empty($post['labels']))
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach(array_slice($post['labels'], 0, 4) as $label)
                                        <span class="rounded-full bg-rosebrown/10 px-3 py-1 text-xs font-medium text-rosebrown">
                                            {{ $label }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-4 text-sm leading-7 text-gray-600">
                                {{ \Illuminate\Support\Str::limit(strip_tags($post['content'] ?? ''), 180) }}
                            </div>

                            <div class="mt-6 flex items-center justify-between gap-4 pt-4">
                                <!-- <a href="{{ $post['url'] ?? '#' }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-full bg-gray-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-rosebrown">
                                        Read article
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.75L21 12m0 0l-3.75 3.25M21 12H3" />
                                        </svg>
                                    </a> -->

                                @if(isset($post['replies']['totalItems']))
                                    <span class="text-sm text-gray-400">
                                        {{ $post['replies']['totalItems'] }} comments
                                    </span>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10 flex items-center justify-between">
    <div>
        @if($previousToken || !empty($previousHistory))
            <a href="{{ route('blog.index', [
                'url' => $currentUrl,
                'pageToken' => $previousToken,
                'history' => $previousHistory,
            ]) }}"
               class="inline-flex items-center rounded-full border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 transition hover:border-rosebrown hover:text-rosebrown">
                Previous
            </a>
        @endif
    </div>

    <div>
        @if($nextPageToken)
            <a href="{{ route('blog.index', [
                'url' => $currentUrl,
                'pageToken' => $nextPageToken,
                'history' => $nextHistory,
            ]) }}"
               class="inline-flex items-center rounded-full bg-gray-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-rosebrown">
                Next
            </a>
        @endif
    </div>
</div>
            @else
                <div class="rounded-[1.75rem] border border-dashed border-gray-300 bg-white/80 p-12 text-center shadow-soft">
                    <h3 class="font-serif text-2xl text-ink">No posts found</h3>
                    <p class="mt-3 text-gray-500">There are no posts to display right now.</p>
                </div>
            @endif
        </section>
    </div>
</body>
</html>