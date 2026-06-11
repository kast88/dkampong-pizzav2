<!DOCTYPE html>
<html>
<head>
    <title>Watch Video</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Inter',sans-serif;
        }

        body{
            background:#0f172a;
            color:white;
        }

        /* HEADER */
        header{
            padding:30px;
            text-align:center;
            background:linear-gradient(135deg,#ef4444,#f97316);
        }

        header h1{
            font-size:32px;
            margin-bottom:8px;
        }

        /* CONTAINER */
        .container{
            max-width:1000px;
            margin:auto;
            padding:25px;
        }

        /* VIDEO CARD */
        .video-card{
            background:#1e293b;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 10px 25px rgba(0,0,0,0.35);
            margin-bottom:30px;
        }

        .video-player iframe{
            width:100%;
            height:550px;
            border:none;
        }

        .video-content{
            padding:20px;
        }

        .video-title{
            font-size:24px;
            font-weight:700;
            margin-bottom:15px;
            line-height:1.5;
        }

        .video-stats{
            display:flex;
            flex-wrap:wrap;
            gap:15px;
            font-size:14px;
            opacity:0.85;
        }

        /* BUTTONS */
        .actions{
            margin-top:20px;
            display:flex;
            gap:10px;
            flex-wrap:wrap;
        }

        .btn{
            display:inline-block;
            padding:12px 18px;
            border-radius:12px;
            text-decoration:none;
            color:white;
            font-size:14px;
            transition:0.3s;
        }

        .back-btn{
            background:#ef4444;
        }

        .back-btn:hover{
            background:#dc2626;
        }

        .youtube-btn{
            background:#f97316;
        }

        .youtube-btn:hover{
            background:#ea580c;
        }

        /* COMMENTS */
        .comments-section{
            margin-top:30px;
        }

        .comments-header{
            margin-bottom:20px;
        }

        .comments-header h2{
            font-size:24px;
        }

        .comment-count{
            background:#f97316;
            padding:6px 12px;
            border-radius:10px;
            font-size:13px;
            font-weight:600;
        }

        .comment-card{
            background:#1e293b;
            padding:18px;
            border-radius:16px;
            margin-bottom:18px;
            transition:0.3s;
            border:1px solid rgba(255,255,255,0.05);
        }

        .comment-card:hover{
            transform:translateY(-3px);
            border-color:rgba(249,115,22,0.3);
        }

        .comment-top{
            display:flex;
            align-items:center;
            gap:12px;
            margin-bottom:12px;
        }

        .avatar{
            width:45px;
            height:45px;
            border-radius:50%;
            background:linear-gradient(135deg,#ef4444,#f97316);
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:bold;
            font-size:16px;
        }

        .author{
            font-weight:700;
            font-size:15px;
        }

        .comment-text{
            opacity:0.9;
            line-height:1.7;
            font-size:14px;
        }

        /* LOAD BUTTONS */
        .comment-actions{
            text-align:center;
            margin-top:25px;
        }

        .comment-btn{
            padding:12px 20px;
            border:none;
            border-radius:12px;
            color:white;
            cursor:pointer;
            font-size:14px;
            transition:0.3s;
            margin:5px;
        }

        .more-btn{
            background:#f97316;
        }

        .more-btn:hover{
            background:#ea580c;
        }

        .less-btn{
            background:#ef4444;
        }

        .less-btn:hover{
            background:#dc2626;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);

            display: none;
            align-items: center;
            justify-content: center;

            z-index: 9999;
        }

        .modal.active {
            display: flex;
        }

        .modal-box {
            background: #1e293b;
            width: 90%;
            max-width: 700px;
            max-height: 80vh;
            overflow-y: auto;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* MOBILE */
        @media(max-width:768px){

            .video-player iframe{
                height:250px;
            }

            .video-title{
                font-size:18px;
            }

            .video-stats{
                flex-direction:column;
                gap:8px;
            }

        }

    </style>
</head>

<body>

<!-- HEADER -->
<header>
    <h1>🍕 D'Kampong Pizza Video Player</h1>
    <p>Watch Videos & Explore Community Comments</p>
</header>

<div class="container">

    <!-- VIDEO -->
    <div class="video-card">

        <div class="video-player">

            <iframe
                src="https://www.youtube.com/embed/{{ $id }}"
                allowfullscreen>
            </iframe>

        </div>

        <div class="video-content">

            @php

                $snippet = $video['snippet'] ?? [];
                $stats = $video['statistics'] ?? [];

                $title = $snippet['title'] ?? 'YouTube Video';

                $channel = $snippet['channelTitle'] ?? 'Unknown Channel';

                $views = $stats['viewCount'] ?? 0;

                $likes = $stats['likeCount'] ?? 0;

                $commentsTotal = $stats['commentCount'] ?? 0;

                $published = $snippet['publishedAt'] ?? now();

            @endphp

            <div class="video-title">
                {{ $title }}
            </div>

            <div class="video-stats">

                <span>
                    👤 {{ $channel }}
                </span>

                <span>
                    👁 {{ number_format($views) }} views
                </span>

                <span>
                    ❤️ {{ number_format($likes) }} likes
                </span>

                <span>
                    💬 {{ number_format($commentsTotal) }} comments
                </span>

                <span>
                    📅 {{ \Carbon\Carbon::parse($published)->diffForHumans() }}
                </span>

            </div>

            <div class="actions">

                <a href="/" class="btn back-btn">
                    ← Back to Homepage
                </a>

                <a href="https://youtube.com/watch?v={{ $id }}"
                   target="_blank"
                   class="btn youtube-btn">
                    ▶ Open in YouTube
                </a>

                <button onclick="openCommentsModal()"
                        class="btn"
                        style="background:#3b82f6;">
                    💬 YouTube Comments
                </button>

            </div>

        </div>

    </div>
@auth
<div class="mt-10 bg-gradient-to-br from-zinc-900 to-zinc-950 p-6 rounded-2xl border border-white/5 shadow-xl">

    <h3 class="text-xl font-bold mb-5 flex items-center gap-2">
        ✍️ Write a Review
    </h3>

    <form method="POST"
          action="{{ route('reviews.store', $id) }}"
          enctype="multipart/form-data"
          class="space-y-4">

        @csrf

        <textarea name="content"
                  class="w-full p-4 rounded-xl bg-zinc-800/70 border border-white/10 text-white focus:outline-none focus:border-orange-400 transition"
                  placeholder="Share your thoughts about this video..."
                  required></textarea>

        <input type="file"
               name="image"
               class="w-full text-sm text-zinc-300 file:bg-orange-500 file:text-white file:px-4 file:py-2 file:rounded-lg file:border-0">

        <button class="bg-gradient-to-r from-orange-500 to-red-500 px-5 py-2 rounded-xl text-white font-semibold hover:opacity-90 transition">
            Post Review
        </button>

    </form>

</div>
@else
<div class="mt-10 bg-zinc-900/60 p-6 rounded-2xl border border-white/5 text-center">

    <p class="text-zinc-400 mb-4">
        You must be logged in to write a review.
    </p>

    <a href="{{ route('login') }}"
       class="inline-block bg-orange-500 px-5 py-2 rounded-xl text-white font-semibold hover:bg-orange-600 transition">
        Login to Continue
    </a>

</div>
@endauth


<!-- REVIEWS -->
<div class="mt-10">

    <h3 class="text-xl font-bold mb-6 flex items-center justify-between">
        <span>💬 Community Reviews</span>

        <span class="text-xs bg-orange-500/20 text-orange-300 px-3 py-1 rounded-full">
            {{ $reviews->count() }}
        </span>
    </h3>

    <div class="space-y-5">

        @forelse($reviews as $review)

            <div class="bg-zinc-900/70 border border-white/5 p-5 rounded-2xl hover:border-orange-500/20 transition">

                <!-- HEADER -->
                <div class="flex items-start justify-between gap-3">

                    <div class="flex items-center gap-3">

                        <!-- Avatar -->
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center font-bold text-sm shadow">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>

                        <div>
                            <div class="font-semibold text-white text-sm">
                                {{ $review->user->name }}
                            </div>

                            <div class="text-xs text-zinc-500">
                                {{ $review->created_at->diffForHumans() }}
                            </div>
                        </div>

                    </div>

                    @if($review->user_id == auth()->id())
                        <div class="flex gap-3 text-xs">

                            <form method="POST" action="{{ route('reviews.update', $review->id) }}">
                                @csrf
                                @method('PUT')

                                <button class="text-green-400 hover:text-green-300">
                                    Edit
                                </button>
                            </form>

                            <form method="POST" action="{{ route('reviews.destroy', $review->id) }}">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-400 hover:text-red-300">
                                    Delete
                                </button>
                            </form>

                        </div>
                    @endif

                </div>

                <!-- CONTENT -->
                <p class="mt-4 text-zinc-300 text-sm leading-relaxed">
                    {{ $review->content }}
                </p>

                <!-- IMAGE -->
                @if($review->image)
                    <img src="{{ asset('storage/'.$review->image) }}"
                         class="mt-4 rounded-xl max-h-72 w-full object-cover border border-white/10">
                @endif

                <!-- ACTIONS -->
                <div class="flex items-center gap-6 mt-4 text-xs text-zinc-400">

                    <button class="hover:text-white transition flex items-center gap-1">
                        👍 Like
                    </button>

                    <button class="hover:text-white transition flex items-center gap-1">
                        👎 Dislike
                    </button>

                    <button class="hover:text-white transition flex items-center gap-1">
                        💬 Reply
                    </button>

                </div>

            </div>

        @empty

            <div class="text-center py-10 text-zinc-500">
                No reviews yet. Be the first to share your thoughts ✨
            </div>

        @endforelse

    </div>
</div>

    <!-- COMMENTS MODAL -->
    <div id="commentsModal" class="modal">

        <div class="modal-box">

            <!-- HEADER -->
            <div style="display:flex;justify-content:space-between;align-items:center;padding:15px;border-bottom:1px solid rgba(255,255,255,0.1);">

                <h2 style="font-size:18px;">
                    💬 YouTube Comments
                    <span style="background:rgba(249,115,22,0.2);padding:4px 8px;border-radius:10px;font-size:12px;">
                        {{ number_format($video['statistics']['commentCount'] ?? 0) }}
                    </span>
                </h2>

                <button onclick="closeCommentsModal()" style="background:none;border:none;color:white;font-size:20px;cursor:pointer;">
                    ✕
                </button>

            </div>

            <!-- BODY -->
            <div style="padding:15px;">

                @foreach($comments as $comment)

                    @php
                        $snippet = $comment['snippet']['topLevelComment']['snippet'];
                        $author = $snippet['authorDisplayName'];
                        $text = $snippet['textDisplay'];
                        $avatarLetter = strtoupper(substr($author,0,1));
                    @endphp

                    <div style="display:flex;gap:10px;margin-bottom:15px;">

                        <div style="width:40px;height:40px;border-radius:10px;
                            background:linear-gradient(135deg,#ef4444,#f97316);
                            display:flex;align-items:center;justify-content:center;font-weight:bold;">
                            {{ $avatarLetter }}
                        </div>

                        <div>
                            <div style="font-weight:600;font-size:14px;">
                                {{ $author }}
                            </div>

                            <div style="font-size:13px;color:#cbd5e1;">
                                {!! $text !!}
                            </div>
                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

<script>

function openCommentsModal() {
    document.getElementById('commentsModal').classList.add('active');
}

function closeCommentsModal() {
    document.getElementById('commentsModal').classList.remove('active');
}

// click outside to close
document.getElementById('commentsModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeCommentsModal();
    }
});

</script>

</body>
</html>
