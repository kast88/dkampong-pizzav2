@extends('layouts.app')

@section('content')

@php
    $user = auth()->user();
@endphp

@php
    $notificationCount = 3;
@endphp

<div class="min-h-screen bg-zinc-950 text-white">

    @php
    $categories = [
    [
    'name' => 'Food Talk',
    'icon' => '🍕',
    'desc' => 'Food discussion, recipes & recommendations'
    ],
    [
    'name' => 'Reviews',
    'icon' => '⭐',
    'desc' => 'Review food, places & services'
    ],
    [
    'name' => 'General Chat',
    'icon' => '💬',
    'desc' => 'Anything under the kampung roof'
    ],
    [
    'name' => 'Kampung Stories',
    'icon' => '📖',
    'desc' => 'Share memories & experiences'
    ],
    [
    'name' => 'Gaming',
    'icon' => '🎮',
    'desc' => 'Games, tips & discussions'
    ],
    [
    'name' => 'Technology',
    'icon' => '💻',
    'desc' => 'Gadget, apps & tech talk'
    ],
    [
    'name' => 'Sports',
    'icon' => '⚽',
    'desc' => 'Sports discussion'
    ],
    [
    'name' => 'Marketplace',
    'icon' => '🛒',
    'desc' => 'Buy, sell & trade'
    ],
    ];
    @endphp

    <!-- MAIN AREA -->

    <div class="max-w-7xl mx-auto px-5 py-8 grid grid-cols-12 gap-6">
        <!-- LEFT SIDEBAR -->
        <aside class="hidden lg:block col-span-3">
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5 mb-5">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto rounded-full bg-orange-600 flex items-center justify-center text-4xl">
                    👨‍🌾
                    </div>
                    <h3 class="font-bold mt-3">
                    {{auth()->user()->name ?? 'Guest'}}
                    </h3>
                    <p class="text-xs text-zinc-500">
                    {{auth()->user()->role ?? 'Guest'}}
                    </p>
                </div>
                <div class="mt-4 border-t border-zinc-800 pt-4 text-sm text-zinc-400">
                    <div>
                        📝 Posts: 24
                    </div>
                    <div>
                        ❤️ Reactions: 340
                    </div>
                    <div>
                        🏆 Reputation: Gold Member
                    </div>
                </div>
                <a href="{{route('profile.edit')}}"
                class="block mt-4 text-center bg-orange-600 rounded-lg py-2 text-sm">
                    Edit Profile
                </a>
            </div>
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">
                <h2 class="font-bold mb-4">
                    🏡 Community Menu
                </h2>
                <ul class="space-y-3 text-sm text-zinc-400">
                    <li class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        📰
                        <span>Home Feed</span>
                    </li>
                    <a href="{{ route('landing') }}"
                    class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        🏡
                        <span>Jalan2 D'Kampung</span>
                    </a>
                    <li class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        🔥
                        <span>Trending</span>
                    </li>
                    <li class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        🏆
                        <span>Popular Posts</span>
                    </li>
                    <li class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        🔖
                        <span>Saved Posts</span>
                    </li>
                    <li class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        📩
                        <span>Messages</span>
                    </li>
                    <li class="hover:text-orange-400 cursor-pointer flex items-center justify-between transition">
                        <div class="flex items-center gap-3">
                            🔔
                            <span>Notifications</span>
                        </div>
                        @if($notificationCount > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $notificationCount }}
                        </span>
                        @endif
                    </li>
                    <li class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        👥
                        <span>Members</span>
                    </li>
                    <li class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        ⚙️
                        <span>Settings</span>
                    </li>
                    <li onclick="openModal('aboutModal')"
                    class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        🌳
                        <span>About D'Kampung</span>
                    </li>
                    <li onclick="openModal('rulesModal')"
                    class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        📌
                        <span>Rules</span>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button
                                type="submit"
                                class="w-full flex items-center gap-3 text-red-500 hover:text-red-400 transition cursor-pointer">

                                <span>🚪</span>
                                <span>Log Out</span>

                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- CENTER FEED START -->

        <main class="col-span-12 lg:col-span-6 space-y-5">

        <!-- CREATE POST BOX -->

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-bold">
                    🏡 D'Kampung Community Corner
                </h1>
            </div>
            <div class="flex gap-3 items-center mb-4">
                <div class="w-11 h-11 rounded-full bg-orange-600 flex items-center justify-center overflow-hidden">
                    @if($user && $user->profile_photo)
                    <img src="{{ asset('storage/'.$user->profile_photo) }}"
                    class="w-full h-full object-cover">
                    @else
                    👨‍🌾
                    @endif
                </div>
                <span class="text-zinc-400">
                    {{ $user ? $user->name : 'Guest' }},
                    what's happening in the kampung today?
                </span>
            </div>
            <select class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 text-sm mb-3">
                <option>
                    Select Category
                </option>
                @foreach($categories as $cat)
                <option value="{{ $cat['name'] }}">
                    {{ $cat['icon'] }} {{ $cat['name'] }}
                </option>
                @endforeach
            </select>
            <input class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 mb-3 text-sm"
                placeholder="Post title...">
            <textarea rows="3" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 text-sm"
                placeholder="Share your thoughts with the kampung..."></textarea>
            <div class="flex justify-between items-center mt-4">
                <div class="flex gap-4 text-sm text-zinc-500">
                    <button class="hover:text-orange-400">
                        🖼️ Photo
                    </button>
                    <button class="hover:text-orange-400">
                        📍 Location
                    </button>
                    <button class="hover:text-orange-400">
                        😊 Feeling
                    </button>
                    <button class="hover:text-orange-400">
                        📊 Poll
                    </button>
                    <button class="hover:text-orange-400">
                        🎥 Live
                    </button>
                </div>
                <button class="bg-orange-600 hover:bg-orange-700 px-5 py-2 rounded-xl text-sm font-semibold">
                    Post
                </button>
            </div>
        </div>

        <!-- SEARCH + CATEGORIES -->

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6">
            <div class="relative">
                <input type="text"
                    placeholder="🔍 Search posts, users, topics..."
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl
                    px-4 py-3 text-sm
                    focus:outline-none focus:border-orange-500
                    transition">
            </div>
            <div class="border-t border-zinc-800 my-6"></div>
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-white">
                        📂 Explore Categories
                    </h2>
                    <span class="text-xs text-zinc-500">
                        {{ count($categories) }} Topics
                    </span>
                </div>
                <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">

                    <!-- ALL -->

                    <button
                    class="category-btn whitespace-nowrap px-4 py-2 rounded-full
                    bg-orange-600 text-white text-sm font-medium"
                    data-category="ALL">

                        🌎 All

                    </button>

                    @foreach($categories as $cat)

                    <button
                    class="category-btn whitespace-nowrap px-4 py-2 rounded-full
                    bg-zinc-950 border border-zinc-800
                    text-zinc-400 text-sm
                    hover:text-orange-400 hover:border-orange-500 transition"
                    data-category="{{ $cat['name'] }}">

                        {{ $cat['icon'] }}
                        {{ $cat['name'] }}

                    </button>

                    @endforeach

                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <button class="px-4 py-2 rounded-lg bg-orange-600 text-sm">
                Newest
            </button>
            <button class="px-4 py-2 rounded-lg bg-zinc-900 border border-zinc-800 text-sm">
                Popular
            </button>
            <button class="px-4 py-2 rounded-lg bg-zinc-900 border border-zinc-800 text-sm">
                Trending
            </button>
        </div>

        <!-- SAMPLE THREAD 1 -->

        <article class="post-card bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden"
            data-category="Food Talk">

            <!-- USER HEADER -->

            <div class="p-5 flex justify-between">
                <div class="flex gap-3">
                    <div class="w-11 h-11 rounded-full bg-orange-600 flex items-center justify-center">
                        👨‍🌾
                    </div>
                    <div>
                        <h3 class="font-semibold">
                            Ali Kampung
                        <span
                        class="text-xs bg-orange-600 px-2 py-1 rounded-full">
                            Top Contributor
                        </span>
                        </h3>
                        <p class="text-xs text-zinc-500">
                            Food Talk 🍕 • 2 hours ago
                        </p>
                    </div>
                </div>
                <button class="text-zinc-500">
                    ⋮
                </button>
            </div>

            <!-- POST CONTENT -->

            <div class="px-5 pb-5">
                <h2 class="text-xl font-bold">
                    Best pizza place around kampung?
                </h2>
                <p class="text-zinc-300 mt-3">
                    Tried a few places recently.
                    Anyone got recommendation?
                    Looking for something that tastes homemade 🍕🔥
                </p>

                <!-- fake image area -->

                <div
                    class="mt-4 h-48 rounded-xl bg-gradient-to-br from-orange-900/40 to-zinc-800 flex items-center justify-center text-6xl">
                    🍕
                </div>
            </div>

            <!-- POST ACTION -->

            <div class="border-t border-zinc-800 px-5 py-3 flex justify-between text-sm text-zinc-400">
                <button class="hover:text-orange-400">
                    👍 <span>124</span> Likes
                </button>

                <button class="hover:text-orange-400">
                    💬 <span>38</span> Comments
                </button>
                <button class="hover:text-orange-400">
                    🔁 <span>14</span> Shares
                </button>
                <button class="hover:text-orange-400">
                    🔖 Save
                </button>
                <button class="hover:text-orange-400">
                    🚩 Report
                </button>
                👀 2.1k Views
            </div>
            <div class="border-t border-zinc-800 p-5">
                <div class="text-sm">
                    <p>
                        <strong>Mak Cik Siti</strong>
                        <span class="text-zinc-400">
                            Sedap tu. Saya recommend Pizza Warung.
                        </span>
                    </p>
                    <p class="mt-3">
                        <strong>Gamer Pakcik</strong>
                        <span class="text-zinc-400">
                            Saya pun nak try.
                        </span>
                    </p>
                    <button class="mt-3 text-orange-400 text-sm">
                        View all 38 comments
                    </button>
                </div>
            </div>
        </article>

        <!-- SAMPLE THREAD 2 GAMING -->

        <article class="post-card bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden"
            data-category="Gaming">
            <div class="p-5 flex gap-3">
                <div class="w-11 h-11 rounded-full bg-purple-600 flex items-center justify-center">
                    🎮
                </div>
                <div>
                    <h3 class="font-semibold">
                        Gamer Pakcik
                    </h3>
                    <p class="text-xs text-zinc-500">
                        Gaming 🎮 • 5 hours ago
                    </p>
                </div>
            </div>
            <div class="px-5 pb-5">
                <h2 class="text-xl font-bold">
                    Anyone still playing old school games?
                </h2>
                <p class="text-zinc-300 mt-3">
                    Thinking to build a small gaming corner.
                    What games should we bring back?
                </p>
            </div>
            <div class="border-t border-zinc-800 px-5 py-3 flex justify-between text-sm text-zinc-400">
                <button class="hover:text-orange-400">
                    👍 <span>86</span> Likes
                </button>
                <button class="hover:text-orange-400">
                    💬 <span>21</span> Comments
                </button>
                <button class="hover:text-orange-400">
                    🔁 <span>10</span> Shares
                </button>
                <button class="hover:text-orange-400">
                    🔖 Save
                </button>
                <button class="hover:text-orange-400">
                    🚩 Report
                </button>
                👀 1.5k Views
            </div>
        </article>

        <!-- POLL POST -->

        <article class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">
            <h2 class="text-xl font-bold">
                🍛 Favourite Kampung Food?
            </h2>
            <div class="mt-4 space-y-2">
            <label>
            <input type="radio">
                Nasi Lemak
            </label>
            <label>
            <input type="radio">
                Mee Kari
            </label>
            <label>
            <input type="radio">
                Pizza
            </label>
            </div>
            <button class="mt-4 bg-orange-600 px-4 py-2 rounded-xl">
                Vote
            </button>
        </article>

        <!-- SAMPLE THREAD 3 -->

        <article class="post-card bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden"
            data-category="General Chat">
            <div class="p-5 flex gap-3">
                <div class="w-11 h-11 rounded-full bg-green-600 flex items-center justify-center">
                    👩
                </div>
                <div>
                    <h3 class="font-semibold">
                        Mak Cik Siti
                    </h3>
                    <p class="text-xs text-zinc-500">
                        General Chat 💬 • Yesterday
                    </p>
                </div>
            </div>
            <div class="px-5 pb-5">
                <h2 class="text-xl font-bold">
                    Apa cerita kampung hari ni?
                </h2>
                <p class="text-zinc-300 mt-3">
                    Lama tak borak dengan jiran-jiran.
                    Share cerita menarik hari ni 😄
                </p>
            </div>
            <div class="border-t border-zinc-800 px-5 py-3 flex justify-between text-sm text-zinc-400">
                <button class="hover:text-orange-400">
                    👍 <span>230</span> Likes
                </button>
                <button class="hover:text-orange-400">
                    💬 <span>75</span> Comments
                </button>
                <button class="hover:text-orange-400">
                    🔁 <span>24</span> Shares
                </button>
                <button class="hover:text-orange-400">
                    🔖 Save
                </button>
                <button class="hover:text-orange-400">
                    🚩 Report
                </button>
                👀 1.8k Views
            </div>
        </main>
        </article>

        <!-- RIGHT SIDEBAR -->

        <aside class="hidden lg:block col-span-3 space-y-5">

            <!-- ONLINE NOW -->

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">
                <h2 class="font-bold">
                    🟢 Online Now
                </h2>
                <div class="mt-4 space-y-2 text-sm">
                    <div>🟢 Ali Kampung</div>
                    <div>🟢 Mak Cik Siti</div>
                    <div>🟢 Gamer Pakcik</div>
                    <div>🟢 Amin Pizza</div>
                </div>
            </div>

            <!-- TRENDING -->

            <div class="mt-5 bg-zinc-900 border border-zinc-800 rounded-2xl p-5">
                <h2 class="font-bold mb-4">
                    🔥 Trending Now
                </h2>
                <div class="space-y-4 text-sm">
                    <div class="cursor-pointer hover:text-orange-400">
                        🏡 Best pizza in town?
                        <p class="text-xs text-zinc-500">
                            324 comments
                        </p>
                    </div>
                    <div class="cursor-pointer hover:text-orange-400">
                        🎮 Best game this month?
                        <p class="text-xs text-zinc-500">
                            186 comments
                        </p>
                    </div>
                    <div class="cursor-pointer hover:text-orange-400">
                        🌶️ Sambal level debate
                        <p class="text-xs text-zinc-500">
                            98 comments
                        </p>
                    </div>
                    <div class="border-t border-zinc-800 mt-5 pt-4">
                        <p class="text-sm font-semibold mb-2">
                            Popular Tags
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 rounded-full bg-zinc-800 text-xs">
                                #pizza
                            </span>
                            <span class="px-3 py-1 rounded-full bg-zinc-800 text-xs">
                                #gaming
                            </span>
                            <span class="px-3 py-1 rounded-full bg-zinc-800 text-xs">
                                #kampung
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOP CONTRIBUTORS -->

            <div class="mt-5 bg-zinc-900 border border-zinc-800 rounded-2xl p-5">
                <h2 class="font-bold mb-4">
                    🏆 Top Orang Kampung
                </h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-orange-600 flex items-center justify-center">
                            👨‍🌾
                        </div>
                        <div>
                            <p class="text-sm font-semibold">
                                Ali Kampung
                            </p>
                            <p class="text-xs text-zinc-500">
                                1,240 membawang
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-pink-600 flex items-center justify-center">
                            👩
                        </div>
                        <div>
                            <p class="text-sm font-semibold">
                                Mak Cik Siti
                            </p>
                            <p class="text-xs text-zinc-500">
                                980 membawang
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-purple-600 flex items-center justify-center">
                            🎮
                        </div>
                        <div>
                            <p class="text-sm font-semibold">
                                Gamer Pakcik
                            </p>
                            <p class="text-xs text-zinc-500">
                                760 membawang
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EVENTS -->

            <div class="mt-5 bg-zinc-900 border border-zinc-800 rounded-2xl p-5">
                <h2 class="font-bold">
                    📅 Upcoming Events
                </h2>
                <div class="mt-4 space-y-3 text-sm">
                <div>
                    🍔 Food Festival
                    <p class="text-zinc-500">
                        22 July
                    </p>
                </div>
                <div>
                    🎮 Gaming Night
                    <p class="text-zinc-500">
                        28 July
                    </p>
                </div>
                <div>
                    🥘 Ramadan Bazaar
                    <p class="text-zinc-500">
                        Coming Soon
                    </p>
                </div>
                </div>
            </div>

            <!-- SPONSORED -->

            <article class="bg-zinc-900 border border-orange-700 rounded-2xl p-5">
                <p class="text-xs text-orange-400">
                    Sponsored
                </p>
                <h2 class="text-xl font-bold mt-2">
                    🍕 Pizza Kampung
                </h2>
                <p class="text-zinc-400 mt-2">
                    Get 20% OFF today.
                    Support local businesses.
                </p>
                <a href="{{ route('products.index') }}"
                class="inline-block mt-4 bg-orange-600 px-5 py-2 rounded-xl">
                Order Now →
                </a>
            </article>
        </aside>
    </div>

    <!-- ABOUT MODAL -->

    <div id="aboutModal"
    class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center px-5">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 max-w-lg w-full relative">
            <button onclick="closeModal('aboutModal')"
            class="absolute top-4 right-4 text-zinc-400 hover:text-white">
                ✕
            </button>
            <h2 class="font-bold text-xl mb-4">
                🌳 About D'Kampung
            </h2>
            <p class="text-sm text-zinc-400">
                A friendly digital warung where villagers share stories,
                food reviews, gaming talks and daily conversations.
            </p>
            <div class="border-t border-zinc-800 my-5"></div>
            <h3 class="font-semibold">
                🎯 Purpose
            </h3>
            <p class="text-sm text-zinc-400 mt-2">
                Connecting Malaysians through food, stories,
                local businesses and meaningful discussions.
            </p>
            <h3 class="font-semibold mt-5">
                🎁 Beneficiaries
            </h3>
            <ul class="text-sm text-zinc-400 mt-2 space-y-1">
                <li>• Local Communities</li>
                <li>• Food Lovers</li>
                <li>• Small Businesses</li>
                <li>• Students</li>
            </ul>
            <div class="border-t border-zinc-800 my-5"></div>
            <div class="space-y-2 text-sm text-zinc-400">
                <div>👥 12,800 Members</div>
                <div>🟢 342 Online Now</div>
                <div>💬 58k Comments</div>
                <div>👍 220k Reactions</div>
                <div>📂 8 Categories</div>
            </div>
        </div>
    </div>

    <!-- RULES MODAL -->

    <div id="rulesModal"
    class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center px-5">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 max-w-lg w-full relative">
            <button onclick="closeModal('rulesModal')"
            class="absolute top-4 right-4 text-zinc-400 hover:text-white">
                ✕
            </button>
            <h2 class="font-bold text-xl mb-4">
                📌 Warung Rules
            </h2>
            <ul class="text-sm text-zinc-400 space-y-3">
                <li>
                    ✅ Respect neighbours & user privacy
                </li>
                <li>
                    ✅ Share useful things & no oversharing personal data
                </li>
                <li>
                    ✅ Report harmful content
                </li>
                <li>
                    ✅ Follow community guidelines
                </li>
                <li>
                    ✅ No unnecessary fighting
                </li>
                <li>
                    ✅ Keep kampung spirit alive
                </li>
            </ul>
        </div>
    </div>
    <footer class="border-t border-zinc-800 mt-10">
        <div class="max-w-7xl mx-auto py-6 text-center text-zinc-500 text-sm">
            © 2026 D'Kampung
            • About
            • Privacy
            • Community Rules
            • Developed by D'Kampung Team.
        </div>
    </footer>
</div>

<!-- CATEGORY FILTER SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function(){

    const buttons = document.querySelectorAll('.category-btn');
    const posts = document.querySelectorAll('.post-card');

    buttons.forEach(button => {

        button.addEventListener('click', function(){

            let category = this.dataset.category;

            // button active
            buttons.forEach(btn=>{
                btn.classList.remove(
                    'bg-orange-600',
                    'text-white',
                    'border-orange-500'
                );
                btn.classList.add(
                    'bg-zinc-900',
                    'text-zinc-300',
                    'border-zinc-700'
                );
            });

            this.classList.add(
                'bg-orange-600',
                'text-white',
                'border-orange-500'
            );

            // filter
            posts.forEach(post=>{
                if(
                    category === "ALL" ||
                    post.dataset.category === category
                ){
                    post.style.display="block";
                }
                else{
                    post.style.display="none";
                }
            });
        });
    });
});

function openModal(id){
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id){
    document.getElementById(id).classList.add('hidden');
}

// klik luar modal tutup
window.onclick = function(event){
    if(event.target.classList.contains('fixed')){
        event.target.classList.add('hidden');
    }
}

</script>

@endsection
