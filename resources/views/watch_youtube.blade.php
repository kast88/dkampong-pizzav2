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

    .review-form-card {
        background: linear-gradient(135deg, #18181b, #0f0f12);
        border: 1px solid #27272a;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        transition: 0.3s;
    }

    .review-form-card:hover {
        border-color: rgba(249,115,22,0.4);
        box-shadow: 0 12px 35px rgba(249,115,22,0.12);
    }

    .review-form-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
    }

    /* TEXTAREA */
    .review-textarea {
        width: 100%;
        min-height: 120px;
        padding: 14px;
        border-radius: 14px;
        background: #27272a;
        border: 1px solid #3f3f46;
        color: #fff;
        resize: none;
        outline: none;
        transition: 0.3s;
    }

    .review-textarea:focus {
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249,115,22,0.15);
    }

    /* FILE INPUT */
    .review-file {
        width: 100%;
        font-size: 13px;
        color: #a1a1aa;
    }

    .review-file::file-selector-button {
        background: linear-gradient(135deg, #f97316, #ef4444);
        border: none;
        padding: 8px 14px;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        margin-right: 10px;
        transition: 0.3s;
    }

    .review-file::file-selector-button:hover {
        opacity: 0.9;
    }

    /* BUTTON */
    .review-submit-btn {
        background: linear-gradient(135deg, #f97316, #ef4444);
        padding: 10px 18px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .review-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(249,115,22,0.2);
    }

    /* LOGIN BOX */
    .review-login-card {
        background: rgba(24,24,27,0.7);
        border: 1px solid #27272a;
        border-radius: 18px;
        padding: 22px;
        text-align: center;
    }

    .review-login-text {
        color: #a1a1aa;
        margin-bottom: 14px;
    }

    .review-login-btn {
        display: inline-block;
        background: #f97316;
        color: white;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
        text-decoration: none;
    }

    .review-login-btn:hover {
        background: #ea580c;
    }

    .review-card {
        background: linear-gradient(135deg, #18181b, #0f0f12);
        border: 1px solid #27272a;
        border-radius: 18px;
        padding: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .review-card:hover {
        transform: translateY(-4px);
        border-color: rgba(249, 115, 22, 0.5);
        box-shadow: 0 10px 30px rgba(249, 115, 22, 0.15);
    }

    /* subtle orange glow line */
    .review-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg,
            transparent,
            rgba(249, 115, 22, 0.08),
            transparent
        );
        opacity: 0;
        transition: 0.4s;
        pointer-events: none;
    }

    .review-card:hover::before {
        opacity: 1;
    }

    /* HEADER */
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    /* USER INFO */
    .review-user {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .review-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f97316, #ef4444);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        box-shadow: 0 6px 15px rgba(249, 115, 22, 0.25);
    }

    .review-name {
        font-weight: 600;
        color: #fff;
        font-size: 14px;
    }

    .review-time {
        font-size: 12px;
        color: #71717a;
    }

    /* CONTENT */
    .review-content {
        margin-top: 14px;
        color: #d4d4d8;
        font-size: 14px;
        line-height: 1.6;
    }

    /* IMAGE */
    .review-image {
        margin-top: 15px;
        width: 100%;
        max-height: 280px;
        object-fit: cover;
        border-radius: 14px;
        border: 1px solid #27272a;
        transition: 0.3s;
    }

    .review-card:hover .review-image {
        transform: scale(1.02);
    }

    /* ACTIONS */
    .review-actions {
        margin-top: 15px;
        padding-top: 12px;
        border-top: 1px solid #27272a;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .review-btn {
        background: #27272a;
        border: 1px solid #3f3f46;
        color: #a1a1aa;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        cursor: pointer;
        transition: 0.25s;
    }

    .review-btn:hover {
        background: #3f3f46;
        color: white;
        border-color: rgba(249, 115, 22, 0.4);
    }

    .review-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    /* Base button style */
    .review-action-btn {
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 999px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.25s ease;
        font-weight: 500;
    }

    /* EDIT button */
    .review-edit-btn {
        background: rgba(34, 197, 94, 0.10);
        color: #22c55e;
        border-color: rgba(34, 197, 94, 0.2);
    }

    .review-edit-btn:hover {
        background: rgba(34, 197, 94, 0.18);
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(34, 197, 94, 0.15);
    }

    /* DELETE button */
    .review-delete-btn {
        background: rgba(239, 68, 68, 0.10);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.2);
    }

    .review-delete-btn:hover {
        background: rgba(239, 68, 68, 0.18);
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(239, 68, 68, 0.15);
    }

    /* Optional: group container (for alignment with header) */
    .review-owner-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    /* EMPTY STATE */
    .review-empty {
        text-align: center;
        padding: 40px;
        color: #71717a;
        border: 1px dashed #3f3f46;
        border-radius: 16px;
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

    <div class="review-form-card mt-10">

        <h3 class="review-form-title">
            ✍️ Write a Review
        </h3>

        <form method="POST"
            action="{{ route('reviews.store', $id) }}"
            enctype="multipart/form-data"
            class="space-y-4">

            @csrf

            <textarea name="content"
                    class="review-textarea"
                    placeholder="Share your thoughts about this video..."
                    required></textarea><br><br>

            <input type="file"
                name="image"
                class="review-file">

            <br><br><button class="review-submit-btn">
                Post Review
            </button>

        </form>

    </div>

    @else

    <div class="review-login-card mt-10">

        <p class="review-login-text">
            You must be logged in to write a review.
        </p>

        <a href="{{ route('login') }}"
        class="review-login-btn">
            Login to Continue
        </a>

    </div>

    @endauth


    <!-- REVIEWS -->
    <div class="mt-10">

        <h3 class="text-xl font-bold mb-6 flex items-center justify-between">
            <br><span>💬 Community Reviews</span>

            <span class="text-xs bg-orange-500/20 text-orange-300 px-3 py-1 rounded-full">
                {{ $reviews->count() }}
            </span><br><br>
        </h3>

        <div class="space-y-5">

        @forelse($reviews as $review)

        <div class="review-card">

            <!-- HEADER -->
            <div class="review-header">

                <div class="review-user">

                    <div class="review-avatar">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>

                    <div>
                        <div class="review-name">
                            {{ $review->user->name }}
                        </div>

                        <div class="review-time">
                            {{ $review->created_at->diffForHumans() }}
                        </div>
                    </div>

                </div>

                @if($review->user_id == auth()->id())

                <div class="review-owner-actions">

                    <button type="button"
                        onclick='openEditModal({{ $review->id }}, @json($review->content))'
                        class="review-action-btn review-edit-btn">
                        Edit
                    </button>

                    <form method="POST" action="{{ route('reviews.destroy', $review->id) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="review-action-btn review-delete-btn"
                                onclick="return confirm('Are you sure you want to delete this review?')">
                            Delete
                        </button>
                    </form>

                </div>

                @endif

            </div>

            <!-- CONTENT -->
            <div class="review-content">
                {{ $review->content }}
            </div>

            @if($review->replies->count())
                @foreach($review->replies as $reply)
                    <div class="ml-10 mt-2 text-sm text-zinc-400">
                        <b>{{ $reply->user->name }}</b>: {{ $reply->content }}
                    </div>
                @endforeach
            @endif

            <!-- IMAGE -->
            @if($review->image)
                <img src="{{ asset('storage/'.$review->image) }}"
                    class="review-image">
            @endif

            <!-- ACTIONS -->
            <div class="review-actions">

                <form method="POST" action="{{ route('reviews.react', $review->id) }}">
                    @csrf
                    <input type="hidden" name="type" value="like">
                    <button class="review-btn">👍 Like</button>
                </form>
                <form method="POST" action="{{ route('reviews.react', $review->id) }}">
                    @csrf
                    <input type="hidden" name="type" value="dislike">
                    <button class="review-btn">👎 Dislike</button>
                </form>
                <form method="POST" action="{{ route('reviews.reply', $review->id) }}" class="mt-3 flex gap-2">
                    @csrf

                    <input type="text"
                        name="content"
                        placeholder="Write a reply..."
                        class="flex-1 bg-zinc-800 p-2 rounded-lg text-sm text-white">

                    <button class="review-btn">Reply</button>
                </form>

            </div>

        </div>

        @empty

        <div class="review-empty">
            No reviews yet. Be the first to share your thoughts ✨
        </div>

        @endforelse

        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-box p-4">

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <textarea name="content" id="editContent"
                        class="review-textarea"></textarea>

                <button class="review-submit-btn mt-3">Save</button>
            </form>

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

function openEditModal(id, content) {
    document.getElementById('editModal').classList.add('active');
    document.getElementById('editContent').value = content;
    document.getElementById('editForm').action = `/reviews/${id}`;
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}

document.getElementById('editModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeEditModal();
    }
});

</script>

</body>
</html>
