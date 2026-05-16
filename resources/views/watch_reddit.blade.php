<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Post — D'Kampong Pizza</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',sans-serif}
        body{background:#ffffff;color:#0f172a;padding:36px}
        .wrap{max-width:900px;margin:0 auto}
        header{margin-bottom:18px}
        h1{font-size:18px;font-weight:600}
        .meta{color:#64748b;font-size:13px;margin-bottom:10px}

        .post{padding:18px;border-radius:10px;border:1px solid #eef2f7;background:#fbfdff;margin-bottom:18px}
        .comments{display:flex;flex-direction:column;gap:12px}
        .comment{padding:12px;border-radius:8px;border:1px solid #f1f5f9;background:#fff}
        .back{display:inline-block;margin-bottom:14px;color:#0f172a;text-decoration:none}
    </style>
</head>
<body>
<div class="wrap">

    <a class="back" href="/reddit">← Back to results</a>

    <header>
        <h1>{{ $post['title'] ?? 'Post' }}</h1>
        <div class="meta">r/{{ $post['subreddit'] ?? '' }} • by {{ $post['author'] ?? '' }} • {{ $post['ups'] ?? 0 }}▲ • {{ $post['comments'] ?? 0 }} comments</div>
    </header>

    <div class="post">
        @if(isset($post['selftext']) && $post['selftext'])
            <div style="color:#0f172a;white-space:pre-wrap">{{ $post['selftext'] }}</div>
        @else
            <div style="color:#0f172a">Link post — <a href="https://reddit.com{{ $post['url'] ?? '' }}">Open on Reddit</a></div>
        @endif
    </div>

    <section>
        <h2 style="font-size:16px;margin-bottom:12px">Comments</h2>

        <div class="comments">
            @forelse($comments as $c)
                @php $cd = $c['data'] ?? null; @endphp
                @if($cd && isset($cd['body']))
                    <div class="comment">
                        <div style="font-weight:600">{{ $cd['author'] ?? 'user' }}</div>
                        <div style="color:#475569;margin-top:6px;white-space:pre-wrap">{{ $cd['body'] }}</div>
                    </div>
                @endif
            @empty
                <div class="comment">No comments available.</div>
            @endforelse
        </div>
    </section>

</div>
</body>
</html>
