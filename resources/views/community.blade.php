@extends('layouts.app')

@section('content')

<style>
    /* Modal scrollbar */
    .modal-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .modal-scroll::-webkit-scrollbar-thumb {
        background: #52525b;
        border-radius: 10px;
    }
</style>

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
                    <div
                        class="w-20 h-20 mx-auto rounded-full overflow-hidden bg-orange-600 flex items-center justify-center text-4xl border-2 border-orange-500">
                        @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}"
                            class="w-full h-full object-cover">
                        @else
                        👨‍🌾
                        @endif
                    </div>
                    <h3 class="font-bold mt-3">
                        {{auth()->user()->name ?? 'Guest'}}
                    </h3>
                    <p class="text-xs text-zinc-500">
                        {{auth()->user()->role ?? 'Guest'}}
                    </p>
                </div>
                <div class="mt-4 border-t border-zinc-800 pt-4 text-sm text-zinc-400">
                    @if(auth()->user()->show_profile)
                    @if(auth()->user()->interests)
                    <div class="flex flex-wrap gap-2 justify-center mt-2">
                        @foreach(auth()->user()->interests as $interest)
                        <span class="px-2 py-1 bg-zinc-800 rounded-full text-xs text-orange-400">
                            {{ $interest }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                    @if(auth()->user()->bio)
                    <p class="text-sm text-zinc-400 mt-3">
                        "{{ auth()->user()->bio }}"
                    </p>
                    @endif
                    @endif
                    <div class="mt-2">
                        📝 Posts: 24
                    </div>
                    <div>
                        ❤️ Reactions: 340
                    </div>
                    <div>
                        💎 Platinum Member
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

                            <button type="submit"
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

            <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">

                @csrf

                <div class="mb-10 text-center">
                    <h1 class="text-3xl font-bold">
                        🏡 D'Kampung Community Corner
                    </h1>
                </div>
                <div class="flex gap-3 items-center mb-4">
                    <div class="w-11 h-11 rounded-full bg-orange-600 flex items-center justify-center overflow-hidden">
                        @if($user && $user->profile_photo)
                        <img src="{{ asset('storage/'.$user->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                        👨‍🌾
                        @endif
                    </div>
                    <span class="text-zinc-400">
                        {{ $user ? $user->name : 'Guest' }},
                        what's happening in the kampung today?
                        @if(auth()->user()->show_location && auth()->user()->location)
                        <p class="text-xs text-zinc-500 mt-2">
                            📍 {{ auth()->user()->location }}
                        </p>
                        @endif
                    </span>
                </div>
                <select name="category" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 text-sm mb-3">
                    <option value="">
                        Select Category
                    </option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat['name'] }}">
                        {{ $cat['icon'] }} {{ $cat['name'] }}
                    </option>
                    @endforeach
                </select>
                <input name="title" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 mb-3 text-sm"
                    placeholder="Thread title...">
                <textarea name="content" rows="3"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 text-sm"
                    placeholder="Share your thoughts with the kampung..."></textarea>
                <div id="selectedPhoto" class="hidden mt-4">
                    <img id="postImagePreview" class="rounded-xl max-h-60 w-full object-cover">
                </div>
                <div class="flex justify-between items-center mt-4">
                    <div class="flex gap-4 text-sm text-zinc-500">
                        <label for="photoUpload" class="hover:text-orange-400 cursor-pointer">
                            🖼️ Photo
                        </label>
                        <input type="file" name="image" id="photoUpload" accept="image/*" class="hidden"
                            onchange="openPhotoEditor(event)">
                        <button type="button" class="hover:text-orange-400">
                            📍 Location
                        </button>
                        <button type="button" class="hover:text-orange-400">
                            😊 Feeling
                        </button>
                        <button type="button" class="hover:text-orange-400">
                            📊 Poll
                        </button>
                        <button type="button" onclick="openModal('liveModal')" class="hover:text-orange-400">
                            🎥 Live
                        </button>
                    </div>
                    <button type="submit"
                        class="bg-orange-600 hover:bg-orange-700 px-5 py-2 rounded-xl text-sm font-semibold">
                        Post
                    </button>
                </div>
            </form>

            <!-- SEARCH + CATEGORIES -->

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6">
                <div class="relative">
                    <input type="text" placeholder="🔍 Search posts, users, topics..." class="w-full bg-zinc-950 border border-zinc-800 rounded-xl
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

                        <button class="category-btn whitespace-nowrap px-4 py-2 rounded-full
                        bg-orange-600 text-white text-sm font-medium" data-category="ALL">

                            🌎 All

                        </button>

                        @foreach($categories as $cat)

                        <button class="category-btn whitespace-nowrap px-4 py-2 rounded-full
                        bg-zinc-950 border border-zinc-800
                        text-zinc-400 text-sm
                        hover:text-orange-400 hover:border-orange-500 transition" data-category="{{ $cat['name'] }}">

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

            <!-- THREAD FRPM DB -->

            @foreach($threads as $thread)

            <article class="post-card bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden"
                data-category="{{ $thread->category }}">
                <div class="p-5 flex justify-between items-start">
                    <div class="flex gap-3">
                        <div
                            class="w-11 h-11 rounded-full bg-orange-600 flex items-center justify-center overflow-hidden">
                            @if($thread->user->profile_photo)
                            <img src="{{ asset('storage/'.$thread->user->profile_photo) }}"
                                class="w-full h-full object-cover">
                            @else
                            👨‍🌾
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold">
                                {{ $thread->user->name }}
                            </h3>
                            <p class="text-xs text-zinc-500">
                                {{ $thread->category }}
                                • {{ $thread->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="relative">
                        <button onclick="toggleMenu({{ $thread->id }})" class="text-zinc-400 text-xl">
                            ⋮
                        </button>
                        <div id="menu-{{ $thread->id }}"
                            class="hidden absolute right-0 mt-2 bg-zinc-800 rounded-xl p-2 w-32 z-20">
                            @if($thread->user_id == auth()->id())
                            <button onclick="openEditModal(
                                '{{ $thread->id }}',
                                '{{ addslashes($thread->category) }}',
                                '{{ addslashes($thread->title) }}',
                                '{{ addslashes($thread->content) }}'
                                )" class="block w-full text-left px-3 py-2 hover:bg-zinc-700 rounded-lg text-sm">
                                ✏️ Edit
                            </button>
                            <form action="{{ route('threads.destroy',$thread->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this post?')"
                                    class="w-full text-left px-3 py-2 hover:bg-zinc-700 rounded-lg text-sm text-red-400">
                                    🗑️ Delete
                                </button>
                            </form>
                            @else
                            <button onclick="openReportModal({{ $thread->id }})"
                                class="block w-full text-left px-3 py-2 hover:bg-zinc-700 rounded-lg text-sm text-orange-400">
                                🚩 Report
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="px-5 pb-5">
                    <h2 class="text-xl font-bold">
                        {{ $thread->title }}
                    </h2>
                    <p class="text-zinc-300 mt-3">
                        {{ $thread->content }}
                    </p>
                    @if($thread->image)
                    <img src="{{ asset('storage/'.$thread->image) }}" class="mt-4 rounded-xl w-full">
                    @endif
                </div>
                <div class="border-t border-zinc-800 px-5 py-3 flex justify-between text-sm text-zinc-400">
                    <form action="{{route('threads.like',$thread->id)}}" method="POST">
                        @csrf
                        <button class="hover:text-orange-400">
                            👍 {{ $thread->likes->count() }} Likes
                        </button>
                    </form>
                    <button onclick="openComment({{ $thread->id }})" class="hover:text-orange-400">
                        💬
                        {{ $thread->comments->count() }}
                        Comments
                    </button>
                    <button
                        type="button"
                        onclick="openShareModal('{{ url('/threads/'.$thread->id) }}')"
                        class="hover:text-orange-400">
                            🔁
                            {{ $thread->shares->count() }}
                            Shares
                    </button>
                    <button class="hover:text-orange-400">
                        🔖 Save
                    </button>
                </div>
                <div class="border-t border-zinc-800 p-5">
                    <form action="{{ route('comments.store',$thread->id) }}" method="POST">
                        @csrf
                        <div class="flex gap-3">
                            <input name="content" placeholder="Write a comment..."
                                class="flex-1 bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-2 text-sm">
                            <button class="bg-orange-600 px-4 rounded-xl">
                                Send
                            </button>
                        </div>
                    </form>
                    <div class="mt-5 space-y-3">
                        @foreach($thread->comments as $comment)
                        <div class="bg-zinc-800 rounded-xl p-3">
                            <div class="flex justify-between">
                                <strong>
                                    {{ $comment->user->name }}
                                </strong>
                                @if($comment->user_id == auth()->id())
                                <form action="{{route('comments.destroy',$comment->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 text-xs">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                            <p class="text-zinc-300 text-sm mt-1">
                                {{ $comment->comment }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </article>

            @endforeach


            <!-- SAMPLE THREAD 1 -->

            <article class="post-card bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden"
                data-category="Food Talk">

                <!-- USER HEADER -->

                <div class="p-5 flex justify-between items-start">

                    <!-- Left -->
                    <div class="flex gap-3">
                        <div class="w-11 h-11 rounded-full bg-orange-600 flex items-center justify-center">
                            👨‍🌾
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold">Ali Kampung</h3>
                                <span class="text-xs bg-orange-600 px-2 py-1 rounded-full">
                                    Top Contributor
                                </span>
                            </div>
                            <p class="text-xs text-zinc-500 mt-1">
                                Food Talk 🍕 • 2 hours ago
                            </p>
                        </div>
                    </div>

                    <!-- Right -->
                    <div class="flex items-center gap-2">
                        <button id="followBtn1" onclick="toggleFollow('followBtn1','followIcon1','followText1')"
                            class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition">

                            <span id="followIcon1">+</span>
                            <span id="followText1">Follow</span>

                        </button>
                        <button class="text-zinc-500 hover:text-white text-xl">
                            ⋮
                        </button>
                    </div>
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
                    {{-- 👀 2.1k Views --}}
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
                <div class="p-5 flex justify-between items-start">

                    <!-- Left -->
                    <div class="flex gap-3">

                        <div class="w-11 h-11 rounded-full bg-purple-600 flex items-center justify-center">
                            🎮
                        </div>

                        <div>

                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold">Gamer Pakcik</h3>

                                <span class="text-xs bg-purple-600 px-2 py-1 rounded-full">
                                    Gamer
                                </span>
                            </div>

                            <p class="text-xs text-zinc-500 mt-1">
                                Gaming 🎮 • 5 hours ago
                            </p>

                        </div>

                    </div>

                    <!-- Right -->
                    <div class="flex items-center gap-2">

                        <button id="followBtn2" onclick="toggleFollow('followBtn2','followIcon2','followText2')"
                            class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition">

                            <span id="followIcon2">+</span>
                            <span id="followText2">Follow</span>

                        </button>

                        <button class="text-zinc-500 hover:text-white text-xl">
                            ⋮
                        </button>

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
                    {{-- 👀 1.5k Views --}}
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
                <div class="p-5 flex justify-between items-start">

                    <div class="flex gap-3">

                        <div class="w-11 h-11 rounded-full bg-green-600 flex items-center justify-center">
                            👩
                        </div>

                        <div>

                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold">Mak Cik Siti</h3>

                                <span class="text-xs bg-green-600 px-2 py-1 rounded-full">
                                    Community Helper
                                </span>
                            </div>

                            <p class="text-xs text-zinc-500 mt-1">
                                General Chat 💬 • Yesterday
                            </p>

                        </div>

                    </div>

                    <div class="flex items-center gap-2">

                        <button id="followBtn3" onclick="toggleFollow('followBtn3','followIcon3','followText3')"
                            class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition">

                            <span id="followIcon3">+</span>
                            <span id="followText3">Follow</span>

                        </button>

                        <button class="text-zinc-500 hover:text-white text-xl">
                            ⋮
                        </button>

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
                    {{-- 👀 1.8k Views --}}
                </div>
            </article>
        </main>

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
                <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-orange-600 px-5 py-2 rounded-xl">
                    Order Now →
                </a>
            </article>
        </aside>
    </div>

    <!-- PHOTO EDITOR MODAL -->

    <div id="photoEditor" class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center px-5">

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 w-full max-w-lg">

            <div class="flex justify-between items-center mb-4">

                <h2 class="font-bold text-xl">
                    🖼️ Edit Photo
                </h2>

                <button onclick="closePhotoEditor()">
                    ✕
                </button>

            </div>

            <!-- Preview -->

            <div class="bg-black rounded-xl h-72 flex items-center justify-center overflow-hidden">

                <img id="previewImage" class="max-h-full max-w-full rounded-lg transition">

            </div>

            <!-- Tools -->

            <div class="grid grid-cols-2 gap-3 mt-5">
                <button onclick="rotateImage()" class="bg-zinc-800 py-2 rounded-lg">
                    🔄 Rotate
                </button>
                <button onclick="resetFilter()" class="bg-zinc-800 py-2 rounded-lg">
                    ♻️ Reset
                </button>
                <button onclick="increaseBrightness()" class="bg-zinc-800 py-2 rounded-lg">
                    ☀️ Brightness
                </button>
                <button onclick="makeGray()" class="bg-zinc-800 py-2 rounded-lg">
                    ⚫ Black & White
                </button>
            </div>
            <button onclick="applyPhoto()" class="mt-5 w-full bg-orange-600 py-3 rounded-xl font-semibold">
                Done ✓
            </button>
        </div>
    </div>

    <!-- SHARE MODAL -->
    <div id="shareModal"
    class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 w-80">
            <div class="flex justify-between mb-5">
                <h2 class="font-bold text-lg">
                    🔁 Share Thread
                </h2>
                <button onclick="closeShareModal()">
                    ✕
                </button>
            </div>
            <div class="space-y-3">
                <button onclick="shareFacebook()"
                class="w-full bg-blue-600 py-3 rounded-xl">
                    🔵 Facebook
                </button>
                <button onclick="shareWhatsapp()"
                class="w-full bg-green-600 py-3 rounded-xl">
                    🟢 WhatsApp
                </button>
                <button onclick="copyShareLink()"
                class="w-full bg-zinc-700 py-3 rounded-xl">
                    📋 Copy Link
                </button>
                <button onclick="nativeShare()"
                class="w-full bg-orange-600 py-3 rounded-xl">
                    📱 More...
                </button>
            </div>
        </div>
    </div>

    <!-- ABOUT MODAL -->

    <div id="aboutModal"
        class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center px-5 overflow-y-auto">
        <div
            class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 max-w-lg w-full relative max-h-[85vh] overflow-y-auto modal-scroll">
            <button onclick="closeModal('aboutModal')" class="absolute top-4 right-4 text-zinc-400 hover:text-white">
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

            <h3 class="font-semibold">
                🏅 Community Badge Rewards
            </h3>

            <p class="text-sm text-zinc-400 mt-2">
                Active members can unlock badges and enjoy special discounts
                from participating local businesses.
            </p>

            <div class="mt-4 space-y-3 text-sm">

                <div class="flex items-center justify-between bg-zinc-800 rounded-lg px-4 py-3">
                    <span>
                        💎 Platinum Member
                    </span>
                    <span class="text-orange-400 font-semibold">
                        10% Discount
                    </span>
                </div>

                <div class="flex items-center justify-between bg-zinc-800 rounded-lg px-4 py-3">
                    <span>
                        🥇 Gold Member
                    </span>
                    <span class="text-orange-400 font-semibold">
                        7.5% Discount
                    </span>
                </div>

                <div class="flex items-center justify-between bg-zinc-800 rounded-lg px-4 py-3">
                    <span>
                        🥈 Silver Member
                    </span>
                    <span class="text-orange-400 font-semibold">
                        5% Discount
                    </span>
                </div>

                <div class="flex items-center justify-between bg-zinc-800 rounded-lg px-4 py-3">
                    <span>
                        🥉 Bronze Member
                    </span>
                    <span class="text-orange-400 font-semibold">
                        2.5% Discount
                    </span>
                </div>

            </div>
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

    <div id="rulesModal" class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center px-5">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 max-w-lg w-full relative">
            <button onclick="closeModal('rulesModal')" class="absolute top-4 right-4 text-zinc-400 hover:text-white">
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
                    <div class="w-9 h-9 rounded-full bg-orange-600 flex items-center justify-center text-lg"
                        id="chatAvatar">👩‍🍳</div>
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
                <input id="chatInput" type="text" placeholder="Aa" onkeydown="if(event.key==='Enter') sendChatMessage()"
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
                <input type="text" id="memberSearch" placeholder="🔍 Search members..." oninput="filterMembers()"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-full px-3 py-1.5 text-sm text-white focus:outline-none focus:border-orange-500">
            </div>

            <!-- Members List -->
            <ul id="membersList" class="flex-1 h-96 overflow-y-auto divide-y divide-zinc-800"></ul>
        </div>
    </div>

    <!-- LIVE SETUP MODAL -->

    <div id="liveModal" class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center px-5">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 w-full max-w-lg">
            <button onclick="closeModal('liveModal')" class="float-right text-zinc-400">
                ✕
            </button>
            <h2 class="font-bold text-xl mb-5">
                🔴 Start Live Streaming
            </h2>
            <input id="liveTitle" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 mb-3"
                placeholder="Live title...">
            <select class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3">
                <option>
                    Food Talk
                </option>
                <option>
                    Gaming
                </option>
                <option>
                    General Chat
                </option>
            </select>
            <button type="button" onclick="startLive()" class="mt-5 w-full bg-red-600 py-3 rounded-xl">
                🔴 Go Live
            </button>
        </div>
    </div>

    <div id="liveRoom" class="hidden fixed inset-0 z-50 bg-black/90 flex items-center justify-center">
        <div class="w-full max-w-3xl bg-zinc-900 rounded-2xl overflow-hidden">
            <div class="p-4 flex justify-between">
                <h2 class="font-bold">
                    🔴 LIVE NOW
                </h2>
                <button onclick="closeModal('liveRoom')">
                    ✕
                </button>
            </div>
            <div class="h-80 bg-black flex items-center justify-center text-7xl">
                🎥
            </div>
            <div class="p-4">
                <h3 id="streamTitle" class="font-bold text-xl">
                </h3>
                <p class="text-zinc-400">
                    👀 234 viewers
                </p>
                <div class="mt-4 bg-zinc-800 rounded-xl p-3">
                    💬 Ali:
                    Sedap nampak tu!
                    <br>
                    💬 Gamer Pakcik:
                    Share resepi!
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT THREAD MODAL -->

    <div id="editModal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center">
        <div class="bg-zinc-900 rounded-2xl p-6 w-full max-w-xl">
            <div class="flex justify-between mb-5">
                <h2 class="text-xl font-bold">
                    ✏️ Edit Thread
                </h2>
                <button onclick="closeModal('editModal')">
                    ✕
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <select id="editCategory" name="category"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 mb-3">
                    @foreach($categories as $cat)
                    <option value="{{ $cat['name'] }}">
                        {{ $cat['icon'] }}
                        {{ $cat['name'] }}
                    </option>
                    @endforeach
                </select>
                <input id="editTitle" name="title"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 mb-3">
                <textarea id="editContent" name="content" rows="5"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3"></textarea>
                <button class="mt-5 w-full bg-orange-600 py-3 rounded-xl">
                    Save Changes
                </button>
            </form>
        </div>
    </div>

    <!-- REPORT MODAL -->

    <div id="reportModal" class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center px-5">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 w-full max-w-lg">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-xl font-bold">
                    🚩 Report Thread
                </h2>
                <button onclick="closeModal('reportModal')">
                    ✕
                </button>
            </div>

            <form id="reportForm" method="POST">
                @csrf
                <h3 class="text-sm text-zinc-400 mb-3">
                    Why are you reporting this?
                </h3>
                <div class="space-y-3">
                    <label class="flex gap-3 items-center">
                        <input type="radio" name="reason" value="Spam" required>
                        Spam
                    </label>
                    <label class="flex gap-3 items-center">
                        <input type="radio" name="reason" value="Scam">
                        Scam
                    </label>
                    <label class="flex gap-3 items-center">
                        <input type="radio" name="reason" value="Harassment">
                        Harassment
                    </label>
                    <label class="flex gap-3 items-center">
                        <input type="radio" name="reason" value="Fake Information">
                        Fake Information
                    </label>
                    <label class="flex gap-3 items-center">
                        <input type="radio" name="reason" value="Other">
                        Other
                    </label>
                </div>
                <textarea name="details" rows="4" placeholder="Additional details (optional)..."
                    class="mt-5 w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 text-sm"></textarea>
                <button class="mt-5 w-full bg-orange-600 hover:bg-orange-700 py-3 rounded-xl font-semibold">
                    Submit Report
                </button>
            </form>
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

function toggleFollow(btnId, iconId, textId){

    const btn = document.getElementById(btnId);
    const icon = document.getElementById(iconId);
    const text = document.getElementById(textId);

    const following = text.textContent === "Following";

    if(following){

        text.textContent = "Follow";
        icon.textContent = "+";

        btn.classList.remove(
            "bg-zinc-200",
            "hover:bg-zinc-300",
            "text-zinc-800"
        );

        btn.classList.add(
            "bg-blue-600",
            "hover:bg-blue-700",
            "text-white"
        );
    }else{
        text.textContent = "Following";
        icon.textContent = "✓";

        btn.classList.remove(
            "bg-blue-600",
            "hover:bg-blue-700",
            "text-white"
        );

        btn.classList.add(
            "bg-zinc-200",
            "hover:bg-zinc-300",
            "text-zinc-800"
        );
    }
}

let currentImage = null;
let originalFile = null;
let rotation = 0;
let brightness = 100;
let grayscale = 0;

function openPhotoEditor(event){
    const file = event.target.files[0];
    if(!file){
        return;
    }
    originalFile = file;
    const reader = new FileReader();
    reader.onload = function(e){
        currentImage = e.target.result;
        const img = document.getElementById('previewImage');
        img.src = currentImage;
        resetFilter();
        openModal('photoEditor');
    }
    reader.readAsDataURL(file);
}

function rotateImage(){
    rotation += 90;
    document.getElementById('previewImage')
    .style.transform = `rotate(${rotation}deg)`;
}

function increaseBrightness(){
    brightness += 20;
    document.getElementById('previewImage')
    .style.filter =
    `brightness(${brightness}%)`;
}

function makeGray(){
    grayscale = grayscale ? 0 : 100;
    document.getElementById('previewImage')
    .style.filter =
    `grayscale(${grayscale}%)`;
}

function resetFilter(){
    rotation = 0;
    brightness = 100;
    grayscale = 0;
    const img=document.getElementById('previewImage');
    img.style.transform="rotate(0deg)";
    img.style.filter="none";
}

function applyPhoto(){
    const img = document.getElementById('previewImage');
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const image = new Image();

    image.onload = function(){
        canvas.width = image.width;
        canvas.height = image.height;
        ctx.filter =
        `brightness(${brightness}%) grayscale(${grayscale}%)`;
        ctx.translate(
            canvas.width/2,
            canvas.height/2
        );
        ctx.rotate(
            rotation * Math.PI / 180
        );
        ctx.drawImage(
            image,
            -image.width/2,
            -image.height/2
        );
        canvas.toBlob(function(blob){
            const editedFile = new File(
                [blob],
                originalFile.name,
                {
                    type:"image/jpeg"
                }
            );
            const input =
            document.getElementById('photoUpload');
            const dataTransfer =
            new DataTransfer();
            dataTransfer.items.add(
                editedFile
            );
            input.files =
            dataTransfer.files;
            document.getElementById('postImagePreview').src =
            URL.createObjectURL(blob);
            document
            .getElementById('selectedPhoto')
            .classList.remove('hidden');
            closePhotoEditor();
        },"image/jpeg",0.9);
    }
    image.src = img.src;
}

function closePhotoEditor(){
    document
    .getElementById('photoEditor')
    .classList.add('hidden');
}

function startLive(){

let title =
document.getElementById('liveTitle').value;


if(title.trim()==""){
title="D'Kampung Live";
}


document.getElementById('streamTitle')
.innerText = title;


closeModal('liveModal');

openModal('liveRoom');

}

function previewUpload(event){

    const file = event.target.files[0];

    if(!file){
        return;
    }

    const preview = document.getElementById('postImagePreview');

    preview.src = URL.createObjectURL(file);

    document
    .getElementById('selectedPhoto')
    .classList.remove('hidden');
}

function toggleMenu(id){
    document
    .getElementById('menu-'+id)
    .classList.toggle('hidden');
}

function openEditModal(id, category, title, content){
    document.getElementById('editForm').action =
        '/threads/' + id;
    document.getElementById('editCategory').value =
        category;
    document.getElementById('editTitle').value =
        title;
    document.getElementById('editContent').value =
        content;
    openModal('editModal');
}

function openReportModal(id)
{
    document.getElementById('reportForm').action =
        '/threads/' + id + '/report';

    openModal('reportModal');
}

let shareURL = "";

function openShareModal(url){
    shareURL = url;
    document
    .getElementById('shareModal')
    .classList.remove('hidden');
}

function closeShareModal(){
    document
    .getElementById('shareModal')
    .classList.add('hidden');
}

function shareFacebook(){
    const link =
    "https://www.facebook.com/sharer/sharer.php?u="
    + encodeURIComponent(shareURL);
    window.open(
        link,
        "_blank",
        "width=600,height=500"
    );
}

function shareWhatsapp(){
    const text =
    "Jom tengok thread D'Kampung 🍕\n"
    + shareURL;
    window.open(
        "https://wa.me/?text="
        + encodeURIComponent(text),
        "_blank"
    );
}

function copyShareLink(){
    navigator.clipboard.writeText(shareURL);
    alert("Link berjaya disalin 📋");
}

function nativeShare(){
    if(navigator.share){
        navigator.share({
            title:"D'Kampung Community",
            text:"Jom tengok thread ni 🍕",
            url:shareURL
        });
    }else{
        copyShareLink();
    }
}

</script>

@endsection
