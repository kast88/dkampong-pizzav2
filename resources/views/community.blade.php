@extends('layouts.app')

@section('content')

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


    <!-- COVER HEADER -->
    <div class="border-b border-zinc-800 bg-gradient-to-r from-orange-950/40 via-zinc-900 to-zinc-950">

        <div class="max-w-7xl mx-auto px-5 py-12">

            <div class="flex flex-col md:flex-row gap-6 items-center">

                <!-- COMMUNITY ICON -->

                <div class="w-28 h-28 rounded-full bg-orange-600 flex items-center justify-center text-6xl shadow-xl">
                    🏡
                </div>


                <div>

                    <h1 class="text-4xl font-bold">
                        D'Kampung Community
                    </h1>


                    <p class="text-zinc-400 mt-2 max-w-xl">
                        A digital kampung where people share stories,
                        discuss food, games, technology and everyday life.
                    </p>


                    <div class="flex gap-5 mt-4 text-sm text-zinc-400">

                        <span>
                            👥 12.8k Members
                        </span>

                        <span>
                            📝 3.2k Posts
                        </span>

                        <span>
                            🔥 Active Today
                        </span>

                    </div>

                </div>


            </div>


        </div>


        <!-- CATEGORY NAV -->

        <div class="max-w-7xl mx-auto px-5 pb-5">

            <div class="flex gap-3 overflow-x-auto">


                <button
                class="category-btn px-5 py-2 rounded-full bg-orange-600 text-sm font-semibold whitespace-nowrap"
                data-category="ALL">

                    🌎 All Posts

                </button>



                @foreach($categories as $cat)

                <button
                class="category-btn px-5 py-2 rounded-full border border-zinc-700 bg-zinc-900 hover:border-orange-500 text-sm whitespace-nowrap"
                data-category="{{ $cat['name'] }}">

                    {{ $cat['icon'] }}
                    {{ $cat['name'] }}

                </button>

                @endforeach


            </div>

        </div>


    </div>



    <!-- MAIN AREA -->

    <div class="max-w-7xl mx-auto px-5 py-8 grid grid-cols-12 gap-6">


        <!-- LEFT SIDEBAR -->

        <aside class="hidden lg:block col-span-3">


            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">


                <h2 class="font-bold mb-4">
                    🏡 Community Menu
                </h2>


                <ul class="space-y-3 text-sm text-zinc-400">


                    <li class="hover:text-orange-400 cursor-pointer">
                        📰 Home Feed
                    </li>


                    <li class="hover:text-orange-400 cursor-pointer">
                        🔥 Trending
                    </li>


                    <li class="hover:text-orange-400 cursor-pointer">
                        ⭐ Popular Posts
                    </li>


                    <li class="hover:text-orange-400 cursor-pointer">
                        👥 Members
                    </li>


                    <li class="hover:text-orange-400 cursor-pointer">
                        📌 Rules
                    </li>


                </ul>


            </div>



            <div class="mt-5 bg-zinc-900 border border-zinc-800 rounded-2xl p-5">


                <h3 class="font-bold mb-3">
                    📂 Categories
                </h3>


                <div class="space-y-2 text-sm">


                @foreach($categories as $cat)

                    <div class="text-zinc-400 hover:text-orange-400 cursor-pointer">

                        {{ $cat['icon'] }}
                        {{ $cat['name'] }}

                    </div>

                @endforeach


                </div>


            </div>


        </aside>



        <!-- CENTER FEED START -->

        <main class="col-span-12 lg:col-span-6 space-y-5">


            <!-- CREATE POST BOX -->

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">


                    <select
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 text-sm mb-3">

                        <option>
                            Select Category
                        </option>

                        @foreach($categories as $cat)

                            <option value="{{ $cat['name'] }}">
                            {{ $cat['icon'] }} {{ $cat['name'] }}
                            </option>

                        @endforeach

                    </select>



                    <input
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 mb-3 text-sm"
                    placeholder="Post title...">


                    <textarea
                    rows="3"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-3 text-sm"
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


                        </div>



                        <button
                        class="bg-orange-600 hover:bg-orange-700 px-5 py-2 rounded-xl text-sm font-semibold">

                            Post

                        </button>


                    </div>




            </div>




            <!-- SAMPLE THREAD 1 -->

            <article
            class="post-card bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden"
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

                        ⬆️ 124 Upvotes

                    </button>



                    <button class="hover:text-orange-400">

                        💬 38 Comments

                    </button>



                    <button class="hover:text-orange-400">

                        🔁 Share

                    </button>


                </div>


            </article>







            <!-- SAMPLE THREAD 2 GAMING -->


            <article
            class="post-card bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden"
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

                        ⬆️ 86 Upvotes

                    </button>


                    <button class="hover:text-orange-400">

                        💬 21 Comments

                    </button>


                    <button class="hover:text-orange-400">

                        🔁 Share

                    </button>


                </div>


            </article>






            <!-- SAMPLE THREAD 3 -->


            <article
            class="post-card bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden"
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

                        ⬆️ 230 Upvotes

                    </button>


                    <button class="hover:text-orange-400">

                        💬 75 Comments

                    </button>


                    <button class="hover:text-orange-400">

                        🔁 Share

                    </button>


                </div>

                </main>

            </article>

        <!-- RIGHT SIDEBAR -->

        <aside class="hidden lg:block col-span-3 space-y-5">



            <!-- COMMUNITY CARD -->

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">


                <h2 class="font-bold text-lg">
                    🌳 About D'Kampung
                </h2>


                <p class="text-sm text-zinc-400 mt-3">

                    A friendly digital warung where villagers share stories,
                    food reviews, gaming talks and daily conversations.

                </p>



                <div class="mt-4 space-y-2 text-sm text-zinc-400">


                    <div>
                        👥 12,800 Members
                    </div>


                    <div>
                        🟢 342 Online Now
                    </div>


                    <div>
                        📝 Created 2026
                    </div>


                </div>


                <a href="{{ route('landing') }}"
                class="block text-center w-full mt-5 py-2 rounded-xl bg-orange-600 hover:bg-orange-700 font-semibold text-sm">

                    🍕 Order Pizza

                </a>


            </div>


            <!-- TRENDING -->

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">


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



                </div>


            </div>








            <!-- TOP CONTRIBUTORS -->


            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">


                <h2 class="font-bold mb-4">

                    🏆 Top Villagers

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
                                1,240 karma
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
                                980 karma
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
                                760 karma
                            </p>

                        </div>


                    </div>


                </div>


            </div>









            <!-- COMMUNITY RULES -->


            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">


                <h2 class="font-bold mb-3">

                    📌 Warung Rules

                </h2>



                <ul class="text-sm text-zinc-400 space-y-2">


                    <li>
                        ✅ Respect neighbours
                    </li>


                    <li>
                        ✅ No unnecessary fighting
                    </li>


                    <li>
                        ✅ Share useful things
                    </li>


                    <li>
                        ✅ Keep kampung spirit alive
                    </li>


                </ul>


            </div>



        </aside>


    </div>


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

</script>


@endsection
