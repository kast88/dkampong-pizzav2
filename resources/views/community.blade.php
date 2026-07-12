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
                    <!-- <li onclick="openModal('chatModal')"
                        class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
                        📩
                        <span>Messages</span>
                    </li> -->
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
                    <li onclick="openModal('membersModal')"
                        class="hover:text-orange-400 cursor-pointer flex items-center gap-3 transition">
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
    <!-- CHAT MODAL -->
    <div id="chatModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-end justify-end p-4">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl w-80 flex flex-col overflow-hidden max-h-[80vh]">

            <!-- Header -->
            <div class="flex items-center justify-between bg-zinc-800 px-4 py-3">
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-orange-600 flex items-center justify-center text-lg" id="chatAvatar">👩‍🍳</div>
                    <span class="text-sm font-semibold text-white" id="chatName">Mak Cik Siti</span>
                </div>
                <button onclick="closeModal('chatModal')" class="text-zinc-400 hover:text-white text-lg">✕</button>
            </div>

            <!-- Messages -->
            <div id="chatMessages" class="flex-1 h-72 overflow-y-auto px-3 py-3 space-y-2 bg-zinc-950 text-sm">
                <div class="flex justify-start">
                    <div class="bg-zinc-800 text-white px-3 py-1.5 rounded-2xl max-w-[80%]">
                        Hi! Sedap tu kampung food talk 🍕
                    </div>
                </div>
                <div class="flex justify-end">
                    <div class="bg-orange-600 text-white px-3 py-1.5 rounded-2xl max-w-[80%]">
                        Haha betul! Nak try pizza warung tu
                    </div>
                </div>
            </div>

            <!-- Input -->
            <div class="flex items-center gap-2 px-3 py-3 border-t border-zinc-800 bg-zinc-900">
                <input id="chatInput" type="text" placeholder="Aa"
                    onkeydown="if(event.key==='Enter') sendChatMessage()"
                    class="flex-1 bg-zinc-950 border border-zinc-800 rounded-full px-3 py-1.5 text-sm text-white focus:outline-none focus:border-orange-500">
                <button onclick="sendChatMessage()" class="text-orange-500 hover:text-orange-400 text-lg">➤</button>
            </div>
        </div>
    </div>
    <!-- MEMBERS MODAL -->
    <div id="membersModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-end p-4">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl w-80 flex flex-col overflow-hidden max-h-[80vh]">

            <!-- Header -->
            <div class="flex items-center justify-between bg-zinc-800 px-4 py-3">
                <span class="font-bold text-sm text-white">👥 Kampung Members</span>
                <button onclick="closeModal('membersModal')" class="text-zinc-400 hover:text-white text-lg">✕</button>
            </div>

            <!-- Search -->
            <div class="px-3 py-2 border-b border-zinc-800 bg-zinc-900">
                <input type="text" id="memberSearch" placeholder="🔍 Search members..."
                    oninput="filterMembers()"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-full px-3 py-1.5 text-sm text-white focus:outline-none focus:border-orange-500">
            </div>

            <!-- Members List -->
            <ul id="membersList" class="flex-1 h-96 overflow-y-auto divide-y divide-zinc-800"></ul>
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

function getSmartReply(text){
    const msg = text.toLowerCase().trim();

    const replies = [
        { keywords: ['assalamualaikum', 'salam'], response: 'Waalaikumussalam 🙏' },
        { keywords: ['apa khabar', 'apa cerita'], response: 'Baik je, alhamdulillah! Awak macam mana?' },
        { keywords: ['selamat pagi'], response: 'Selamat pagi juga! 🌞' },
        { keywords: ['selamat petang'], response: 'Selamat petang! Dah makan ke belum?' },
        { keywords: ['selamat malam'], response: 'Selamat malam, jangan tidur lambat sangat 😴' },
        { keywords: ['makan', 'lapar'], response: 'Jom lah, kedai mana nak pergi? 🍛' },
        { keywords: ['sedap', 'best'], response: 'Betul tu! Confirm try lah 😋' },
        { keywords: ['terima kasih', 'thanks', 'tq'], response: 'Sama-sama! 😊' },
        { keywords: ['ok', 'okay', 'baik'], response: 'Okay noted 👍' },
        { keywords: ['bye', 'jumpa lagi'], response: 'Jumpa lagi! Take care 👋' },
        { keywords: ['hai', 'hello', 'hi'], response: 'Hai juga! Ada apa hari ni?' },
    ];

    for(const entry of replies){
        if(entry.keywords.some(keyword => msg.includes(keyword))){
            return entry.response;
        }
    }

    const fallback = [
        'Haha betul tu 👍',
        'Ooo faham faham',
        'Hmm menarik jugak',
        'Betul ke? Cerita lagi',
        'Haha ok noted 👍'
    ];
    return fallback[Math.floor(Math.random() * fallback.length)];
}

function sendChatMessage(){
    const input = document.getElementById('chatInput');
    const box = document.getElementById('chatMessages');
    if(!input.value.trim() || !currentChatMember) return;

    const userText = input.value;
    currentChatMember.messages.push({ from: 'me', text: userText });

    const bubble = document.createElement('div');
    bubble.className = 'flex justify-end';
    bubble.innerHTML = `<div class="bg-orange-600 text-white px-3 py-1.5 rounded-2xl max-w-[80%]">${userText}</div>`;
    box.appendChild(bubble);

    input.value = '';
    box.scrollTop = box.scrollHeight;

    setTimeout(() => {
        const replyText = getSmartReply(userText);
        currentChatMember.messages.push({ from: 'them', text: replyText });

        const reply = document.createElement('div');
        reply.className = 'flex justify-start';
        reply.innerHTML = `<div class="bg-zinc-800 text-white px-3 py-1.5 rounded-2xl max-w-[80%]">${replyText}</div>`;
        box.appendChild(reply);
        box.scrollTop = box.scrollHeight;
    }, 600);
}

const members = [
    {
        id: 1,
        name: 'Mak Cik Siti',
        avatar: '👩‍🍳',
        online: true,
        status: 'Active now',
        messages: [
            { from: 'them', text: 'Hi! Sedap tu kampung food talk 🍕' },
            { from: 'me', text: 'Haha betul! Nak try pizza warung tu' }
        ]
    },
    {
        id: 2,
        name: 'Gamer Pakcik',
        avatar: '🎮',
        online: true,
        status: 'Active now',
        messages: [
            { from: 'them', text: 'Bro nak main game apa hari ni?' }
        ]
    },
    {
        id: 3,
        name: 'Ali Kampung',
        avatar: '👨‍🌾',
        online: false,
        status: 'Offline · 2h ago',
        messages: [
            { from: 'them', text: 'Jom lepak kedai kopi petang ni' }
        ]
    },
    {
        id: 4,
        name: 'Abang Tekno',
        avatar: '💻',
        online: true,
        status: 'Active now',
        messages: []
    }
];

let currentChatMember = null;

function openChatWith(id){
    const member = members.find(m => m.id === id);
    if(!member) return;

    currentChatMember = member;

    document.getElementById('chatAvatar').textContent = member.avatar;
    document.getElementById('chatName').textContent = member.name;

    const box = document.getElementById('chatMessages');
    box.innerHTML = '';

    member.messages.forEach(msg => {
        const bubble = document.createElement('div');
        bubble.className = msg.from === 'me' ? 'flex justify-end' : 'flex justify-start';
        const bubbleColor = msg.from === 'me' ? 'bg-orange-600' : 'bg-zinc-800';
        bubble.innerHTML = `<div class="${bubbleColor} text-white px-3 py-1.5 rounded-2xl max-w-[80%]">${msg.text}</div>`;
        box.appendChild(bubble);
    });

    closeModal('membersModal');
    openModal('chatModal');
    box.scrollTop = box.scrollHeight;
}

function renderMembersList(list = members){
    const ul = document.getElementById('membersList');
    ul.innerHTML = '';

    if(list.length === 0){
        ul.innerHTML = '<li class="px-4 py-6 text-center text-zinc-500 text-sm">No members found 🕵️</li>';
        return;
    }

    list.forEach(member => {
        const li = document.createElement('li');
        li.className = 'flex items-center gap-3 px-4 py-3 hover:bg-zinc-800 cursor-pointer transition';
        li.onclick = () => openChatWith(member.id);

        const statusDot = member.online
            ? '<span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-zinc-900"></span>'
            : '';

        li.innerHTML = `
            <div class="relative">
                <div class="w-10 h-10 rounded-full bg-orange-600 flex items-center justify-center text-lg">${member.avatar}</div>
                ${statusDot}
            </div>
            <div class="text-sm flex-1">
                <p class="text-white font-medium">${member.name}</p>
                <p class="text-xs text-zinc-500">${member.status}</p>
            </div>
            <button onclick="event.stopPropagation(); openChatWith(${member.id})" class="text-orange-500 hover:text-orange-400 text-sm">💬</button>
        `;
        ul.appendChild(li);
    });
}

function filterMembers(){
    const query = document.getElementById('memberSearch').value.trim().toLowerCase();

    const filtered = members.filter(member =>
        member.name.toLowerCase().includes(query)
    );

    renderMembersList(filtered);
}

renderMembersList();

</script>

@endsection
