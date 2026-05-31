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

            </div>

        </div>

    </div>

    <!-- COMMENTS -->
    <div class="comments-section">

        <div class="comments-header">

            <h2 style="
                display:flex;
                align-items:center;
                gap:10px;
            ">

                <span>
                    💬 Community Comments
                </span>

                <span class="comment-count">
                    {{ number_format($commentsTotal) }}
                </span>

            </h2>

        </div>

        @foreach($comments as $index => $comment)

            @php

                $snippet = $comment['snippet']['topLevelComment']['snippet'];

                $author = $snippet['authorDisplayName'];

                $text = $snippet['textDisplay'];

                $avatarLetter = strtoupper(substr($author,0,1));

            @endphp

            <div class="comment-card comment-item"
                 style="{{ $index >= 5 ? 'display:none;' : '' }}">

                <div class="comment-top">

                    <div class="avatar">
                        {{ $avatarLetter }}
                    </div>

                    <div class="author">
                        {{ $author }}
                    </div>

                </div>

                <div class="comment-text">
                    {!! $text !!}
                </div>

            </div>

        @endforeach

        <!-- BUTTONS -->
        <div class="comment-actions">

            <button
                onclick="showMore()"
                id="seeMoreBtn"
                class="comment-btn more-btn">

                See More Comments ↓

            </button>

            <button
                onclick="showLess()"
                id="seeLessBtn"
                class="comment-btn less-btn"
                style="display:none;">

                See Less ↑

            </button>

        </div>

    </div>

</div>

<script>

    let visibleCount = 10;

    const step = 50;

    function updateComments(){

        let items = document.querySelectorAll('.comment-item');

        items.forEach((item,index)=>{

            if(index < visibleCount){
                item.style.display='block';
            }
            else{
                item.style.display='none';
            }

        });

        // SHOW / HIDE MORE BUTTON
        if(visibleCount >= items.length){
            document.getElementById('seeMoreBtn').style.display='none';
        }
        else{
            document.getElementById('seeMoreBtn').style.display='inline-block';
        }

        // SHOW / HIDE LESS BUTTON
        if(visibleCount > step){
            document.getElementById('seeLessBtn').style.display='inline-block';
        }
        else{
            document.getElementById('seeLessBtn').style.display='none';
        }

    }

    function showMore(){

        let items = document.querySelectorAll('.comment-item');

        visibleCount += step;

        if(visibleCount > items.length){
            visibleCount = items.length;
        }

        updateComments();

    }

    function showLess(){

        visibleCount -= step;

        if(visibleCount < 10){
            visibleCount = 10;
        }

        updateComments();

    }

    // INITIAL LOAD
    updateComments();

</script>

</body>
</html>
