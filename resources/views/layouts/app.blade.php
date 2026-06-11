<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? "D'Kampong" }}</title>

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        boxShadow: {
                            glow: '0 10px 30px rgba(239, 68, 68, 0.25)',
                        }
                    }
                }
            }
        </script>
    @endif
</head>
<body class="h-full bg-zinc-950 text-zinc-100 antialiased">
    @session('error')
        <div class="fixed inset-x-0 top-4 z-50 mx-auto w-[calc(100%-2rem)] max-w-xl rounded-2xl border border-red-500/30 bg-red-500/15 px-4 py-3 text-sm text-red-100 backdrop-blur">
            {{ $value }}
        </div>
    @endsession

    @session('success')
        <div class="fixed inset-x-0 top-4 z-50 mx-auto w-[calc(100%-2rem)] max-w-xl rounded-2xl border border-emerald-500/30 bg-emerald-500/15 px-4 py-3 text-sm text-emerald-100 backdrop-blur">
            {{ $value }}
        </div>
    @endsession

    @yield('content')
</body>
</html>
