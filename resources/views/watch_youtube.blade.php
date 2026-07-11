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

        .hidden {
            display: none !important;
        }

        .copy-feedback {
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .copy-feedback.visible {
            opacity: 1;
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
        font-size: 15.5px;
        line-height: 1.8;
        letter-spacing: 0.2px;
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

        .share-btn {
            background: linear-gradient(135deg, #14b8a6, #0f766e);
            border: 1px solid rgba(20, 184, 166, 0.35);
            box-shadow: 0 16px 35px rgba(20, 184, 166, 0.16);
            color: white;
        }

        .share-btn:hover {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
        }

        .comment-btn {
            background: #3b82f6;
        }

        .share-card {
            display: none;
            max-width: 760px;
            width: 100%;
            margin: 0 auto;
            padding: 22px;
            border-radius: 24px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: rgba(15, 23, 42, 0.96);
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.55);
        }

        .share-card:not(.hidden) {
            display: block;
        }

        .share-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }

        .share-actions {
            margin-top: 18px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .share-action,
        .copy-link-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 16px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.25s ease;
            text-decoration: none;
            text-transform: none;
        }

        .share-action {
            border: 1px solid transparent;
        }

        .share-action.whatsapp {
            background: rgba(16, 185, 129, 0.12);
            border-color: rgba(16, 185, 129, 0.35);
            color: #a7f3d0;
        }

        .share-action.facebook {
            background: rgba(59, 130, 246, 0.12);
            border-color: rgba(59, 130, 246, 0.35);
            color: #bfdbfe;
        }

        .share-action.email {
            background: rgba(14, 165, 233, 0.12);
            border-color: rgba(14, 165, 233, 0.35);
            color: #e0f2fe;
        }

        .share-action:hover,
        .copy-link-btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .copy-link-btn {
            background: #111827;
            border: 1px solid #334155;
            color: #e2e8f0;
        }

        .copy-feedback {
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .copy-feedback.visible {
            opacity: 1;
        }

    .review-btn.like {
        color: #22c55e;
        border-color: rgba(34, 197, 94, 0.25);
    }

    .review-btn.like:hover {
        background: rgba(34, 197, 94, 0.08);
    }

    .review-btn.dislike {
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.25);
    }

    .review-btn.dislike:hover {
        background: rgba(239, 68, 68, 0.08);
    }

    .review-btn.reply {
        color: #f97316;
        border-color: rgba(249, 115, 22, 0.25);
    }

    .review-btn.reply:hover {
        background: rgba(249, 115, 22, 0.10);
    }

    .review-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 6px 12px;
        border-radius: 999px;

        font-size: 13px;
        font-weight: 500;

        border: 1px solid #2f2f2f;
        background: #111827;
        color: #e5e7eb;

        cursor: pointer;

        transition: all 0.2s ease;
    }

    .review-btn:hover {
        background: #1f2937;
        border-color: rgba(249, 115, 22, 0.35);
        transform: none;
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

    .review-replies {
        margin-top: 10px;
        margin-left: 45px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .review-reply {
        font-size: 12.5px;
        color: #a1a1aa;
        line-height: 1.5;
    }

    .review-reply b {
        color: #d4d4d8;
        margin-right: 4px;
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

/* =========================
   ACTION BUTTON BAR (CLEAN SYSTEM)
========================= */

.actions{
    margin-top:20px;
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    align-items:center;
}

/* BASE BUTTON */
.btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;

    padding:10px 14px;
    border-radius:12px;

    font-size:14px;
    font-weight:600;

    border:1px solid transparent;
    cursor:pointer;

    transition:0.2s ease;
    color:white;
    text-decoration:none;
}

/* COLORS */
.btn-danger{
    background:#ef4444;
}
.btn-danger:hover{
    background:#dc2626;
}

.btn-orange{
    background:#f97316;
}
.btn-orange:hover{
    background:#ea580c;
}

.btn-teal{
    background:linear-gradient(135deg,#14b8a6,#0f766e);
}
.btn-teal:hover{
    opacity:0.9;
}

.btn-blue{
    background:#3b82f6;
}
.btn-blue:hover{
    background:#2563eb;
}

/* =========================
   LIKE / DISLIKE GROUP
========================= */

.react-group{
    display:flex;
    gap:8px;
    align-items:center;
}

/* BASE REACT BUTTON */
.react-btn{
    padding:10px 14px;
    border-radius:12px;

    font-size:14px;
    font-weight:600;

    background:#1e293b;
    border:1px solid #334155;
    color:white;

    cursor:pointer;
    transition:0.2s ease;
}

.react-btn:hover{
    transform:translateY(-1px);
}

/* ACTIVE STATES */
.react-btn.active-like{
    background:#22c55e;
    border-color:#22c55e;
}

.react-btn.active-dislike{
    background:#ef4444;
    border-color:#ef4444;
}

.react-btn:disabled{
    opacity:0.5;
    cursor:not-allowed;
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

    @if(session('success'))
        <div style="
            background:#16a34a;
            color:white;
            padding:15px;
            border-radius:12px;
            margin-bottom:20px;
        ">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="
            background:#dc2626;
            color:white;
            padding:15px;
            border-radius:12px;
            margin-bottom:20px;
            border:1px solid #ef4444;
        ">
            <strong>Validation Error:</strong>
            <ul style="margin-top:8px; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

                <a href="/" class="btn btn-danger">
                    ← Back to Homepage
                </a>

                <a href="https://youtube.com/watch?v={{ $id }}" target="_blank" class="btn btn-orange">
                    ▶ Open in YouTube
                </a>

                <button type="button" id="shareButton" class="btn btn-teal">
                    🔗 Share Video
                </button>

                <button onclick="openCommentsModal()" class="btn btn-blue">
                    💬 YouTube Comments
                </button>

                <!-- LIKE / DISLIKE GROUP -->
                <div class="react-group">

                    <form method="POST" action="{{ route('posts.react', $post->id) }}">
                        @csrf
                        <input type="hidden" name="type" value="like">

                        <button
                            type="submit"
                            class="react-btn {{ $userReaction == 'like' ? 'active-like' : '' }}"
                            {{ auth()->check() ? '' : 'disabled' }}>
                            👍 {{ $post->likes_count }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('posts.react', $post->id) }}">
                        @csrf
                        <input type="hidden" name="type" value="dislike">

                        <button
                            type="submit"
                            class="react-btn {{ $userReaction == 'dislike' ? 'active-dislike' : '' }}"
                            {{ auth()->check() ? '' : 'disabled' }}>
                            👎 {{ $post->dislikes_count }}
                        </button>
                    </form>

                </div>

            </div>

            <div id="videoShareCard" class="share-card hidden mt-4">
                <div class="share-header">
                    <div>
                        <p class="font-semibold text-white text-lg">Share this video</p>
                        <p class="text-zinc-400 text-sm">Send the video to friends or copy the link.</p>
                    </div>
                    <button type="button" id="closeShareCard" class="share-close text-zinc-400 hover:text-white text-2xl leading-none">&times;</button>
                </div>
                <div class="share-actions">
                    <a href="#" class="share-action whatsapp" data-channel="whatsapp" target="_blank" rel="noreferrer">
                        WhatsApp
                    </a>
                    <a href="#" class="share-action facebook" data-channel="facebook" target="_blank" rel="noreferrer">
                        Facebook
                    </a>
                    <a href="#" class="share-action email" data-channel="email" target="_blank" rel="noreferrer">
                        Email
                    </a>
                    <button type="button" id="copyShareLink" class="copy-link-btn">
                        Copy Link
                    </button>
                </div>
                <p id="copyFeedback" class="copy-feedback mt-3 hidden">Link copied to clipboard!</p>
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
                name="image" accept="image/*"
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

            <!-- IMAGE -->
            @if($review->image)
                <img src="{{ asset('storage/'.$review->image) }}"
                    class="review-image">
            @endif

            <!-- REPLIES -->
            @if($review->replies->count())
                <div class="review-replies">
                    @foreach($review->replies as $reply)
                        <div class="review-reply">
                            <b>{{ $reply->user->name }}</b>:
                            <span>{{ $reply->content }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- ACTIONS -->
            <div class="review-actions">

                <form method="POST" action="{{ route('reviews.react', $review->id) }}">
                    @csrf
                    <input type="hidden" name="type" value="like">
                    <button class="review-btn like">
                        👍 {{ $review->likes_count }}
                    </button>
                </form>
                <form method="POST" action="{{ route('reviews.react', $review->id) }}">
                    @csrf
                    <input type="hidden" name="type" value="dislike">
                    <button class="review-btn dislike">
                        👎 {{ $review->dislikes_count }}
                    </button>
                </form>
                <form method="POST" action="{{ route('reviews.reply', $review->id) }}" class="mt-3 flex gap-2">
                    @csrf

                    <input type="text"
                        name="content"
                        placeholder="Write a reply..."
                        class="flex-1 bg-zinc-800 p-2 rounded-lg text-sm text-white">

                    <button class="review-btn reply">Reply</button>
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

                <div style="text-align:center;">
                    <button class="review-submit-btn mt-3">Save</button>
                </div>
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

(function () {
    const shareButton = document.getElementById('shareButton');
    const shareCard = document.getElementById('videoShareCard');
    const closeShareCard = document.getElementById('closeShareCard');
    const shareActions = document.querySelectorAll('.share-action');
    const copyButton = document.getElementById('copyShareLink');
    const copyFeedback = document.getElementById('copyFeedback');

    if (!shareButton || !shareCard) {
        return;
    }

    function buildShareLinks() {
        const pageUrl = `${window.location.origin}${window.location.pathname}`;
        const videoTitle = document.querySelector('.video-title')?.textContent.trim() || 'D\'Kampong Pizza Video';
        const message = `Check out this D'Kampong Pizza video: ${videoTitle} ${pageUrl}`;

        return {
            whatsapp: `https://wa.me/?text=${encodeURIComponent(message)}`,
            facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(pageUrl)}&quote=${encodeURIComponent(message)}`,
            email: `mailto:?subject=${encodeURIComponent(`Watch this video from D'Kampong Pizza`)}&body=${encodeURIComponent(message)}`,
            link: pageUrl,
        };
    }

    function toggleShareCard() {
        const links = buildShareLinks();
        shareActions.forEach(action => {
            const channel = action.dataset.channel;
            action.href = links[channel] || '#';
        });

        if (copyButton) {
            copyButton.dataset.copyLink = links.link;
        }

        shareCard.classList.toggle('hidden');
    }

    function closeShare() {
        shareCard.classList.add('hidden');
    }

    shareButton.addEventListener('click', toggleShareCard);
    closeShareCard?.addEventListener('click', closeShare);

    if (copyButton) {
        copyButton.addEventListener('click', function () {
            const link = this.dataset.copyLink || window.location.href;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(link).then(() => {
                    copyFeedback?.classList.add('visible');
                    copyFeedback?.classList.remove('hidden');
                    setTimeout(() => {
                        if (copyFeedback) {
                            copyFeedback.classList.remove('visible');
                            copyFeedback.classList.add('hidden');
                        }
                    }, 1600);
                });
            } else {
                window.prompt('Copy this link', link);
            }
        });
    }
})();

</script>

</body>
</html>
