@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-zinc-950 via-zinc-900 to-zinc-950">
    <!-- Navigation Bar -->
    <nav class="w-full top-0 z-[999] relative backdrop-blur-md bg-zinc-950/80 border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">

            <!-- Logo -->
            <a href="{{ route('landing') }}" class="text-2xl font-bold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">🍕 D'Kampong Pizza</a>

            <!-- Navigation Links -->
            <div class="hidden md:flex gap-8 text-zinc-300 font-semibold items-center">

                <a href="#home" class="hover:text-orange-400 transition">Home</a>
                <a href="#menu" class="hover:text-orange-400 transition">Menu</a>
                <a href="#videos" class="hover:text-orange-400 transition">🎥 Videos</a>
                <a href="#reviews" class="hover:text-orange-400 transition">💬 Reviews</a>

                @auth
                    <!-- Cart -->
                    @php
                        $cartCount = auth()->user()->cart?->items->sum('quantity') ?? 0;
                    @endphp

                    <a href="{{ route('cart.index') }}"
                    class="relative px-3 py-2 bg-zinc-800 hover:bg-zinc-700 rounded-full text-white">

                        🛒

                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Orders -->
                    <a href="{{ route('orders.index') }}"
                    class="hover:text-orange-400 transition">
                        📦 Orders
                    </a>

                    <!-- Dashboard -->
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('dashboard') }}"
                        class="hover:text-orange-400 transition">
                            📊 Dashboard
                        </a>
                    @endif
                @endauth

            </div>

            @guest
                <a href="{{ route('login') }}"
                class="px-6 py-2 bg-orange-600 hover:bg-orange-700 rounded-lg font-semibold transition">
                    Login
                </a>
            @endguest

            @auth
            <div x-data="{ open: false }" class="relative">

                <!-- Button -->
                <button
                    @click="open = !open"
                    class="flex items-center gap-3 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 rounded-full font-semibold text-white transition"
                >
                    <!-- Avatar Circle -->
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-500 to-red-500 flex items-center justify-center text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>

                    <!-- Name -->
                    <span class="hidden sm:block max-w-[120px] truncate">
                        {{ Auth::user()->name }}
                    </span>

                    <!-- Chevron Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 opacity-80"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <div
                    x-show="open"
                    @click.away="open = false"
                    x-transition
                    class="absolute right-0 mt-3 w-52 bg-zinc-900 border border-zinc-700 rounded-xl shadow-xl z-50 overflow-hidden"
                >
                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2 px-4 py-3 text-sm text-zinc-200 hover:bg-zinc-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A4 4 0 017 16h10a4 4 0 011.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Edit Profile
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-zinc-800"></div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2 px-4 py-3 text-sm text-red-400 hover:bg-zinc-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V4" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>

            </div>
            @endauth

        </div>
    </nav>

    <!-- Hero Section - Full Image Static -->
    <div id="home" class="relative min-h-screen w-full bg-cover bg-center bg-no-repeat"
        style="background-image: url('/landing_page.png');">
    </div>

    <!-- Content Section -->
    <div class="py-20 px-4" style="background-color: #18181b;">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-8">
                <div class="space-y-4">
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                        <span class="bg-gradient-to-r from-orange-400 via-red-500 to-pink-500 bg-clip-text text-transparent">
                            Authentic Pizza
                        </span>
                        <br>
                        <span class="text-white">That Tastes Like Home</span>
                    </h1>
                    <p class="text-xl text-zinc-300 leading-relaxed">
                        Experience the authentic flavors of traditional kampung-style pizza, crafted with the finest ingredients and generations of passion. Every bite is a journey to culinary excellence.
                    </p>
                </div>

                <!-- Features -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-orange-500/20 flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl">🔥</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Fresh Ingredients Daily</h3>
                            <p class="text-sm text-zinc-400">Sourced from local farmers and premium suppliers</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-orange-500/20 flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl">👨‍🍳</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Expert Pizza Masters</h3>
                            <p class="text-sm text-zinc-400">Years of tradition perfected in every creation</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-orange-500/20 flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl">⚡</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Fast & Reliable Delivery</h3>
                            <p class="text-sm text-zinc-400">Hot pizzas delivered to your doorstep in minutes</p>
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="pt-6">
                    <button class="relative inline-block group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-orange-600 to-red-600 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative px-8 py-4 bg-zinc-950 rounded-2xl leading-none flex items-center gap-2 cursor-pointer hover:bg-zinc-900 transition">
                            <span class="text-lg font-bold">Order Now</span>
                            <span class="text-2xl">🍕</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Right - Pizza Illustration -->
            <div class="relative flex items-center justify-center">
                <!-- Floating Pizza -->
                <div class="relative w-96 h-96 flex items-center justify-center">
                    <!-- Glow effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-500/20 to-red-500/20 rounded-full blur-3xl"></div>

                    <!-- Pizza -->
                    <svg class="relative w-full h-full drop-shadow-2xl animate-bounce" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <!-- Pizza base circle -->
                        <circle cx="100" cy="100" r="95" fill="#D4A574" stroke="#C89968" stroke-width="2"/>

                        <!-- Sauce -->
                        <circle cx="100" cy="100" r="88" fill="#C41E3A" opacity="0.9"/>

                        <!-- Cheese -->
                        <circle cx="100" cy="100" r="85" fill="#F4A460" opacity="0.95"/>

                        <!-- Pepperoni slices -->
                        <circle cx="80" cy="70" r="8" fill="#B71C1C" opacity="0.9"/>
                        <circle cx="75" cy="85" r="7" fill="#B71C1C" opacity="0.9"/>
                        <circle cx="95" cy="75" r="8" fill="#B71C1C" opacity="0.9"/>
                        <circle cx="110" cy="80" r="7" fill="#B71C1C" opacity="0.9"/>
                        <circle cx="125" cy="75" r="8" fill="#B71C1C" opacity="0.9"/>

                        <circle cx="70" cy="110" r="8" fill="#B71C1C" opacity="0.9"/>
                        <circle cx="90" cy="115" r="7" fill="#B71C1C" opacity="0.9"/>
                        <circle cx="130" cy="110" r="8" fill="#B71C1C" opacity="0.9"/>
                        <circle cx="110" cy="125" r="7" fill="#B71C1C" opacity="0.9"/>

                        <!-- Basil leaves -->
                        <ellipse cx="85" cy="95" rx="6" ry="4" fill="#22C55E" opacity="0.8" transform="rotate(-20 85 95)"/>
                        <ellipse cx="120" cy="105" rx="6" ry="4" fill="#22C55E" opacity="0.8" transform="rotate(25 120 105)"/>
                        <ellipse cx="100" cy="120" rx="6" ry="4" fill="#22C55E" opacity="0.8" transform="rotate(-30 100 120)"/>

                        <!-- Pizza slice line 1 (top) -->
                        <line x1="100" y1="15" x2="100" y2="100" stroke="#8B7355" stroke-width="1.5" opacity="0.5"/>

                        <!-- Pizza slice line 2 (bottom-left) -->
                        <line x1="100" y1="100" x2="28" y2="153" stroke="#8B7355" stroke-width="1.5" opacity="0.5"/>

                        <!-- Pizza slice line 3 (bottom-right) -->
                        <line x1="100" y1="100" x2="172" y2="153" stroke="#8B7355" stroke-width="1.5" opacity="0.5"/>
                    </svg>

                    <!-- Decorative stars -->
                    <div class="absolute top-12 right-10 text-4xl animate-spin" style="animation-duration: 4s;">✨</div>
                    <div class="absolute bottom-20 left-8 text-3xl animate-pulse">⭐</div>
                    <div class="absolute top-1/4 left-0 text-3xl animate-pulse" style="animation-delay: 0.5s;">⭐</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 px-4 border-y border-zinc-800" style="background-color: #27272a;">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16">
                <span class="bg-gradient-to-r from-orange-400 to-red-500 bg-clip-text text-transparent">
                    Why Choose Us
                </span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 rounded-xl border border-zinc-700 bg-gradient-to-br from-zinc-800/50 to-transparent hover:border-orange-500/50 transition">
                    <div class="text-5xl mb-4">🏆</div>
                    <h3 class="text-xl font-bold mb-3 text-white">Award Winning</h3>
                    <p class="text-zinc-400">
                        Recognized as the best pizza in the region with countless satisfied customers and premium ratings.
                    </p>
                </div>

                <div class="p-8 rounded-xl border border-zinc-700 bg-gradient-to-br from-zinc-800/50 to-transparent hover:border-orange-500/50 transition">
                    <div class="text-5xl mb-4">🌶️</div>
                    <h3 class="text-xl font-bold mb-3 text-white">Premium Quality</h3>
                    <p class="text-zinc-400">
                        Only the finest imported cheeses, fresh vegetables, and authentic Italian spices make it to our pizzas.
                    </p>
                </div>

                <div class="p-8 rounded-xl border border-zinc-700 bg-gradient-to-br from-zinc-800/50 to-transparent hover:border-orange-500/50 transition">
                    <div class="text-5xl mb-4">💝</div>
                    <h3 class="text-xl font-bold mb-3 text-white">Customer Love</h3>
                    <p class="text-zinc-400">
                        Built on trust and passion, we treat every customer like family and ensure complete satisfaction.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Section -->
    <section id="menu" class="py-20 px-4 relative" style="background-image: url('/menu.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold">
                    <span class="bg-gradient-to-r from-orange-400 to-red-500 bg-clip-text text-transparent">
                        Our Menu
                    </span>
                </h2>
            </div>

            <!-- Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button class="filter-btn active px-6 py-2 rounded-full font-semibold border border-orange-500 bg-orange-500/20 text-orange-400 transition hover:bg-orange-500/30" data-filter="*">
                    All
                </button>
                @foreach($categories as $cat)
                    <button class="filter-btn px-6 py-2 rounded-full font-semibold border border-zinc-600 text-zinc-300 transition hover:border-orange-500 hover:text-orange-400" data-filter=".{{ Str::slug($cat) }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <!-- Menu Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 menu-items-container">

                @foreach($products as $product)
                <div class="menu-item all {{ Str::slug($product->category) }}">
                    <div class="rounded-lg overflow-hidden border border-zinc-700 bg-zinc-800/50 hover:border-orange-500/50 transition-all transform hover:scale-105">
                        <div class="w-full h-64 bg-gradient-to-br from-zinc-700 to-zinc-800 flex items-center justify-center relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-br from-orange-500/10 to-red-500/10"></div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $product->name }}</h3>
                            <p class="text-zinc-400 text-sm mb-4">{{ $product->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-orange-400 font-bold text-lg">RM {{ number_format($product->price, 0) }}</span>
                                @auth
                                    <form method="POST" action="{{ route('cart.add', $product) }}">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 rounded-lg font-semibold transition text-sm">
                                            Add to Cart 🛒
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 rounded-lg font-semibold transition text-sm">
                                        Login to Order
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- YouTube Section -->
    <section id="videos" class="py-20 px-4 bg-zinc-950">

        <h2 class="text-4xl font-bold text-center mb-12 text-white">
            🎥 What People Say on YouTube
        </h2>

        <div class="grid md:grid-cols-3 gap-6">
        @foreach($youtubeVideos as $video)

            <div class="relative bg-zinc-900 rounded-xl overflow-hidden border border-zinc-800 hover:border-red-500 transition group">

                <!-- Thumbnail -->
                <div class="relative group">

                    <!-- Thumbnail (default) -->
                    <img
                        src="{{ $video['thumbnail'] }}"
                        class="w-full h-48 object-cover transition duration-300 group-hover:opacity-0"
                    >

                    <!-- YouTube Preview (hover only) -->
                    <iframe
                        class="absolute inset-0 w-full h-48 opacity-0 group-hover:opacity-100 transition"
                        src="https://www.youtube.com/embed/{{ $video['id'] }}?autoplay=1&mute=1&controls=0&rel=0&modestbranding=1"
                        allow="autoplay; encrypted-media"
                        allowfullscreen
                    ></iframe>

                    <!-- Play overlay -->
                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 group-hover:opacity-0 transition">
                    </div>

                </div>

                <!-- Content -->
                <div class="p-4">
                    <h3 class="text-white font-semibold text-sm line-clamp-2">
                        {{ $video['title'] }}
                    </h3>

                    <p class="text-zinc-400 text-xs mt-1">
                        {{ $video['channel'] }}
                    </p>

                    <!-- Stats -->
                    <div class="flex gap-3 text-xs text-zinc-400 mt-2">
                        <span>👁 {{ number_format($video['views']) }}</span>
                        <span>👍 {{ number_format($video['likes']) }}</span>
                        <span>💬 {{ number_format($video['comments']) }}</span>
                    </div>

                    <div class="flex gap-2 mt-3">

                        <!-- Button 1: YouTube -->
                        <a href="https://www.youtube.com/watch?v={{ $video['id'] }}"
                        target="_blank"
                        class="flex-1 text-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition">
                            ▶ YouTube
                        </a>

                        <!-- Button 2: Your custom page -->
                        <a href="{{ route('video.watch', $video['id']) }}"
                        class="flex-1 text-center px-3 py-2 bg-zinc-800 hover:bg-zinc-700 text-white text-sm rounded-lg border border-zinc-700 transition">
                            🎬 Watch
                        </a>

                    </div>
                </div>

            </div>

        @endforeach
        </div>
    </section>

    <!-- Reddit Reviews Section -->
    <section id="reviews" class="py-20 px-4 bg-zinc-900">
        <div class="max-w-7xl mx-auto">

            <h2 class="text-4xl font-bold text-center mb-12 text-white">
                💬 Reddit Discussions
            </h2>

            <div class="grid md:grid-cols-2 gap-6">

                @foreach($redditReviews as $review)

                <a href="{{ $review['url'] }}" target="_blank"
                class="block p-6 rounded-xl bg-zinc-950 border border-zinc-800 hover:border-orange-500 transition">

                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <p class="text-orange-400 font-semibold">u/{{ $review['user'] }}</p>
                            <p class="text-white font-bold text-sm">{{ $review['title'] }}</p>
                        </div>

                        <div class="text-right text-zinc-400 text-sm">
                            🔺 {{ $review['upvotes'] }}<br>
                            💬 {{ $review['comments'] }}
                        </div>
                    </div>

                    <p class="text-zinc-300 mt-3">
                        {{ $review['text'] }}
                    </p>

                </a>

                @endforeach

            </div>
        </div>
    </section>

    <!-- Footer CTA -->
    <div class="py-20 px-4 border-t border-zinc-800" style="background-color: #27272a;">
        <div class="max-w-4xl mx-auto text-center space-y-8">
            <h2 class="text-4xl md:text-5xl font-bold">
                Ready for a Delicious Experience?
            </h2>
            <p class="text-xl text-zinc-300">
                Join thousands of satisfied customers enjoying authentic kampung-style pizza
            </p>
            <a href="#menu" class="relative inline-block group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-orange-600 to-red-600 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative px-10 py-5 bg-zinc-950 rounded-2xl leading-none flex items-center gap-3 cursor-pointer hover:bg-zinc-900 transition">
                    <span class="text-xl font-bold">Order Your Pizza Now</span>
                    <span class="text-3xl">🍕</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-zinc-800 py-8 px-4" style="background-color: #18181b;">
        <div class="max-w-7xl mx-auto text-center text-zinc-400 text-sm">
            <p>&copy; 2026 D'Kampong Pizza. All rights reserved. | Crafted with ❤️</p>
        </div>
    </footer>
</div>

<style>
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .animate-bounce {
        animation: bounce 3s infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .animate-spin {
        animation: spin var(--animation-duration, 2s) linear infinite;
    }

    /* Menu filtering */
    .menu-item {
        opacity: 1;
        animation: fadeIn 0.5s ease-in;
    }

    .menu-item.hidden {
        display: none;
        opacity: 0;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .filter-btn.active {
        @apply border-orange-500 bg-orange-500/20 text-orange-400;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const menuItems = document.querySelectorAll('.menu-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active', 'border-orange-500', 'bg-orange-500/20', 'text-orange-400'));
                filterBtns.forEach(b => b.classList.add('border-zinc-600', 'text-zinc-300'));

                // Add active class to clicked button
                this.classList.add('active', 'border-orange-500', 'bg-orange-500/20', 'text-orange-400');
                this.classList.remove('border-zinc-600', 'text-zinc-300');

                const filterValue = this.getAttribute('data-filter');

                // Filter menu items
                menuItems.forEach(item => {
                    if (filterValue === '*') {
                        item.classList.remove('hidden');
                    } else {
                        if (item.classList.contains(filterValue.substring(1))) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    }
                });
            });
        });
    });
</script>
@endsection
