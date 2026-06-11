<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <style type="text/tailwindcss">
            @theme {
                --color-brand-50: #fff7ed;
                --color-brand-100: #ffedd5;
                --color-brand-200: #fed7aa;
                --color-brand-300: #fdba74;
                --color-brand-400: #fb923c;
                --color-brand-500: #f97316;
                --color-brand-600: #ea580c;
                --color-brand-700: #c2410c;
                --color-brand-800: #9a3412;
                --color-brand-900: #7c2d12;

                --color-accent-red-500: #dc2626;
                --color-accent-red-600: #b91c1c;
                --color-dark-900: #0f0f0f;
                --color-dark-800: #1a1a1a;
            }
        </style>
    @endif
</head>
<body class="min-h-screen bg-neutral-100 text-slate-900 antialiased">
    <div class="relative isolate min-h-screen overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(249,115,22,0.18),_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(220,38,38,0.14),_transparent_30%)]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_bottom_right,_rgba(255,255,255,0.88),_rgba(245,245,245,0.95))]"></div>
        </div>

        <div class="mx-auto flex min-h-screen max-w-6xl items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-3xl border border-orange-100 bg-white/90 shadow-2xl shadow-black/10 backdrop-blur xl:grid-cols-2">

                <!-- Left side / branding -->
                <div class="hidden xl:flex flex-col justify-between bg-gradient-to-br from-neutral-950 via-neutral-900 to-orange-950 px-10 py-12 text-white">
                    <div>
                        <div class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/10 px-4 py-2 text-sm text-orange-100">
                            <span class="h-2.5 w-2.5 rounded-full bg-orange-400"></span>
                            Join 10,000+ pizza lovers
                        </div>

                        <div class="mt-10">
                            <p class="text-sm uppercase tracking-[0.25em] text-orange-200/70">
                                {{ config('app.name', 'Laravel') }}
                            </p>
                            <h1 class="mt-4 text-4xl font-bold leading-tight">
                                Fresh pizza, faster ordering, better experience.
                            </h1>
                            <p class="mt-4 max-w-md text-base leading-7 text-orange-50/80">
                                Order, track, and enjoy your favorite pizzas.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-0 gap-4">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <p class="text-sm text-orange-200/70">Back for more?</p>
                            <p class="mt-2 text-lg font-semibold text-white">Your pizza is waiting 🍕</p>
                        </div>
                        {{-- <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <p class="text-sm text-orange-200/70">System</p>
                            <p class="mt-2 text-lg font-semibold text-white">Admin control</p>
                        </div> --}}
                    </div>
                </div>

                <!-- Right side / form -->
                <div class="flex items-center justify-center px-6 py-10 sm:px-10 sm:py-12">
                    <div class="w-full max-w-md">
                        <div class="mb-8 xl:hidden">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-600 text-white shadow-lg shadow-orange-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75A4.75 4.75 0 0 0 11.75 2 4.75 4.75 0 0 0 7 6.75v3.75m-1.5 0h12a1.5 1.5 0 0 1 1.5 1.5v7.5a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 4 19.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                </svg>
                            </div>
                            <h1 class="mt-4 text-3xl font-bold tracking-tight text-neutral-900">
                                Login
                            </h1>
                            <p class="mt-2 text-sm text-neutral-600">
                                Sign in to continue to {{ config('app.name', 'Laravel') }}.
                            </p>
                        </div>

                        <div class="hidden xl:block mb-8">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-brand-600">Sign in to your account</p>
                            <h2 class="mt-2 text-3xl font-bold tracking-tight text-neutral-900">
                                Welcome back
                            </h2>
                            <p class="mt-2 text-sm text-neutral-600">
                                Enter your credentials to access the dashboard.
                            </p>
                        </div>

                        @if ($errors->any())
                            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                                    </svg>
                                    <ul class="space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                            @csrf

                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-neutral-700">
                                    Email address
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    placeholder="you@example.com"
                                    class="block w-full rounded-2xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 shadow-sm outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-orange-100"
                                >
                            </div>

                            <div>
                                <div class="mb-2 flex items-center justify-between">
                                    <label for="password" class="block text-sm font-medium text-neutral-700">
                                        Password
                                    </label>
                                    <a href="{{ route('password.request.form') }}"
                                    class="text-sm font-medium text-brand-600 hover:text-brand-700">
                                        Forgot password?
                                    </a>
                                </div>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    required
                                    placeholder="Enter your password"
                                    class="block w-full rounded-2xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 shadow-sm outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-orange-100"
                                >
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <label for="remember" class="inline-flex cursor-pointer items-center gap-3 text-sm text-neutral-600">
                                    <input
                                        type="checkbox"
                                        name="remember"
                                        id="remember"
                                        class="h-4 w-4 rounded border-neutral-300 text-brand-600 focus:ring-brand-500"
                                    >
                                    <span>Remember me</span>
                                </label>
                            </div>

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-orange-300 active:scale-[0.99]"
                            >
                                Login
                            </button>

                            <a
                                href="{{ route('register') }}"
                                class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-neutral-300 bg-white px-4 py-2.5 text-sm font-semibold text-neutral-700 shadow-sm transition hover:border-orange-500 hover:bg-orange-50 hover:text-orange-600"
                            >
                                Create new account
                            </a>

                            <a href="{{ url('/') }}"
                                class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-neutral-300 bg-white px-4 py-2.5 text-sm font-semibold text-neutral-700 shadow-sm transition hover:border-orange-500 hover:bg-orange-50 hover:text-orange-600"
                            >
                                Back to Homepage
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
