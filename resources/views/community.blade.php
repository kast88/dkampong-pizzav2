@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-zinc-950 via-zinc-900 to-zinc-950 text-white">

    <!-- HEADER -->
    <div class="text-center py-16 px-4 border-b border-zinc-800">
        <div class="text-5xl mb-4">🏡🌳</div>

        <h1 class="text-4xl md:text-5xl font-bold">
            D'Kampung Social Network
        </h1>

        <p class="text-zinc-400 mt-3 max-w-2xl mx-auto">
            A forum-style digital warung where villagers gather, talk, review food & even argue about pizza toppings 🍕
        </p>
    </div>

    @php
        $categories = [
            'Food Talk 🍕',
            'Reviews 💬',
            'General Chat 🗣️',
            'Kampung Stories 📖',
            'Gaming 🎮'
        ];
    @endphp

    <!-- CATEGORY BAR -->
    <div class="max-w-7xl mx-auto px-4 mt-10">
        <div class="flex flex-wrap gap-3 justify-center">

            <!-- ALL -->
            <button
                class="category-btn px-4 py-2 rounded-full text-sm font-semibold transition
                border border-orange-500 bg-orange-500/10 text-orange-300"
                data-category="ALL">
                🌍 All
            </button>

            <!-- CATEGORIES -->
            @foreach($categories as $cat)
                <button
                    class="category-btn px-4 py-2 rounded-full text-sm font-semibold transition
                    border border-zinc-700 bg-zinc-900/40 text-zinc-300 hover:border-orange-500 hover:text-orange-300"
                    data-category="{{ $cat }}">
                    {{ $cat }}
                </button>
            @endforeach

        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="max-w-7xl mx-auto px-4 py-12 grid lg:grid-cols-3 gap-8">

        <!-- LEFT: FEED -->
        <div class="lg:col-span-2 space-y-6">

            <!-- POST BOX -->
            <div class="p-5 rounded-2xl border border-zinc-800 bg-zinc-900/40">

                <p class="font-semibold mb-3">🪵 Start a new discussion</p>

                <!-- category select -->
                <select id="postCategory"
                        class="w-full mb-3 bg-zinc-950 border border-zinc-800 rounded-xl p-2 text-sm">
                    <option disabled selected>Select category...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>

                <!-- title -->
                <input
                    type="text"
                    class="w-full mb-3 bg-zinc-950 border border-zinc-800 rounded-xl p-3 text-sm"
                    placeholder="Thread title (e.g. Best pizza in kampung?)"
                >

                <!-- content -->
                <textarea
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 text-sm"
                    rows="3"
                    placeholder="Share your thoughts..."
                ></textarea>

                <div class="flex justify-between items-center mt-3">
                    <span class="text-zinc-500 text-xs">
                        Forum rules: Be nice like kampung neighbours 😊
                    </span>

                    <button class="px-4 py-2 bg-orange-600 hover:bg-orange-700 rounded-lg text-sm font-semibold">
                        Post Thread 📝
                    </button>
                </div>
            </div>

            <!-- SAMPLE POSTS -->
            <div class="space-y-4">

                <!-- POST 1 -->
                <div class="post-card p-5 rounded-2xl border border-zinc-800 bg-zinc-900/30" data-category="Food Talk 🍕">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold">👨‍🌾 Ali</p>
                            <span class="text-xs text-orange-400">Food Talk 🍕</span>
                        </div>
                        <span class="text-zinc-500 text-xs">2h ago</span>
                    </div>

                    <h3 class="mt-2 font-bold text-white">
                        Kampung pizza really hits different 🔥
                    </h3>

                    <p class="mt-2 text-zinc-300">
                        Taste macam makan dekat rumah kayu time hujan...
                    </p>

                    <div class="flex gap-4 mt-4 text-sm text-zinc-400">
                        <span>❤️ 24</span>
                        <span>💬 8</span>
                        <span>🔁 Reply</span>
                    </div>
                </div>

                <!-- POST 2 -->
                <div class="post-card p-5 rounded-2xl border border-zinc-800 bg-zinc-900/30" data-category="Gaming 🎮">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold">🎮 Gamer Pakcik</p>
                            <span class="text-xs text-orange-400">Gaming 🎮</span>
                        </div>
                        <span class="text-zinc-500 text-xs">5h ago</span>
                    </div>

                    <h3 class="mt-2 font-bold text-white">
                        Anyone playing Pizza Simulator 2026?
                    </h3>

                    <p class="mt-2 text-zinc-300">
                        This game make me hungry every time 😂🍕
                    </p>

                    <div class="flex gap-4 mt-4 text-sm text-zinc-400">
                        <span>❤️ 56</span>
                        <span>💬 12</span>
                        <span>🔁 Reply</span>
                    </div>
                </div>

                <!-- POST 3 -->
                <div class="post-card p-5 rounded-2xl border border-zinc-800 bg-zinc-900/30" data-category="General Chat 🗣️">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold">👩 Mak Cik Siti</p>
                            <span class="text-xs text-orange-400">General Chat 🗣️</span>
                        </div>
                        <span class="text-zinc-500 text-xs">1d ago</span>
                    </div>

                    <h3 class="mt-2 font-bold text-white">
                        Warung always open for gossip 😆
                    </h3>

                    <p class="mt-2 text-zinc-300">
                        Sit long enough, someone will argue about sambal level 🌶️
                    </p>

                    <div class="flex gap-4 mt-4 text-sm text-zinc-400">
                        <span>❤️ 90</span>
                        <span>💬 30</span>
                        <span>🔁 Reply</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT SIDEBAR -->
        <div class="space-y-6">

            <!-- COMMUNITY INFO -->
            <div class="p-6 rounded-2xl border border-orange-900/40 bg-gradient-to-br from-zinc-900 to-zinc-950">
                <h2 class="text-xl font-bold mb-2">🌳 Kampung Forum Hub</h2>

                <p class="text-zinc-400 text-sm">
                    Like Reddit but with more sambal & less toxicity 😆
                </p>

                <div class="mt-4 text-sm text-zinc-500 space-y-1">
                    <p>👥 Members: 1,284 villagers</p>
                    <p>📂 Categories: 5 active boards</p>
                    <p>🔥 Status: Always open warung</p>
                </div>
            </div>

            <!-- TRENDING -->
            <div class="p-6 rounded-2xl border border-zinc-800 bg-zinc-900/40">
                <h3 class="font-semibold mb-2">🔥 Trending Topics</h3>

                <ul class="text-sm text-zinc-400 space-y-2">
                    <li>🍕 Pizza vs Nasi Lemak debate</li>
                    <li>🎮 Best mobile games 2026</li>
                    <li>🌶️ Spicy level competition</li>
                </ul>
            </div>

        </div>
    </div>
</div>

<!-- SIMPLE FILTER SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.category-btn');
    const posts = document.querySelectorAll('.post-card');

    function showPosts(category) {
        posts.forEach(post => {
            const postCat = post.getAttribute('data-category');

            if (category === 'ALL') {
                post.style.display = "block";
            } else {
                post.style.display = (postCat === category) ? "block" : "none";
            }
        });
    }

    function setActive(btn) {
        buttons.forEach(b => {
            b.classList.remove(
                'border-orange-500',
                'bg-orange-500/10',
                'text-orange-300'
            );

            b.classList.add(
                'border-zinc-700',
                'bg-zinc-900/40',
                'text-zinc-300'
            );
        });

        btn.classList.remove(
            'border-zinc-700',
            'bg-zinc-900/40',
            'text-zinc-300'
        );

        btn.classList.add(
            'border-orange-500',
            'bg-orange-500/10',
            'text-orange-300'
        );
    }

    // default
    showPosts('ALL');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const cat = btn.getAttribute('data-category');
            setActive(btn);
            showPosts(cat);
        });
    });

});
</script>
@endsection
