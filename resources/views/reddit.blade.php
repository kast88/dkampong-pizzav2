<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reddit — D'Kampong Pizza</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        *{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',sans-serif}
        body{background:#ffffff;color:#0f172a;padding:40px}
        .wrap{max-width:980px;margin:0 auto}
        header{padding:28px 0;border-bottom:1px solid #e6edf3;margin-bottom:28px}
        header h1{font-weight:600;font-size:20px}
        header p{color:#475569;margin-top:6px;font-size:13px}

        .search{margin:24px 0}
        .search form{display:flex;gap:8px}
        .search input{flex:1;padding:10px 12px;border:1px solid #e6edf3;border-radius:8px;background:transparent}
        .search button{padding:10px 14px;border:none;background:#0f172a;color:white;border-radius:8px;cursor:pointer}

        .list{display:grid;gap:14px}
        .card{padding:16px;border-radius:10px;border:1px solid #eef2f7;background:#fbfdff;display:flex;justify-content:space-between;align-items:center}

        .meta{color:#475569;font-size:13px}
        .title{font-weight:600;color:#0f172a}
        .stats{display:flex;gap:12px;color:#64748b;font-size:13px}

        .view-btn{background:transparent;border:1px solid #e6edf3;padding:8px 12px;border-radius:8px;color:#0f172a;text-decoration:none}

        footer{margin-top:40px;color:#94a3b8;font-size:13px;text-align:center}
    </style>

    <script>
        // Placeholder for tiny interactive bits if needed
    </script>

</head>
<body>

<div class="wrap">

    <header>
        <h1>Reddit — D'Kampong Pizza</h1>
        <p>Community signals and post insights — formal & minimalist</p>
    </header>

    <div class="search">
        <form method="GET">
            <input name="search" value="{{ $search }}" placeholder="Search Reddit posts...">
            <button>Search</button>
        </form>
    </div>

    <div class="list">

        @forelse($posts as $post)

            <div class="card">

                <div>
                    <div class="title">{{ $post['title'] }}</div>
                    <div class="meta">r/{{ $post['subreddit'] }} • by {{ $post['author'] }} • {{ \Carbon\Carbon::parse($post['created'])->diffForHumans() }}</div>
                    <div class="stats" style="margin-top:8px">
                        <div>▲ {{ number_format($post['ups']) }}</div>
                        <div>💬 {{ number_format($post['comments']) }}</div>
                        <div>Engagement: {{ $post['engagement'] }}%</div>
                    </div>
                </div>

                <div style="text-align:right">
                    <a class="view-btn" href="/watch_reddit/{{ $post['id'] }}">View</a>
                </div>

            </div>

        @empty

            <div class="card">
                <div>No posts found for "{{ $search }}".</div>
            </div>

        @endforelse

    </div>

    <div style="margin-top:20px;display:flex;gap:8px;justify-content:center">
        @if($before)
            <form method="GET"><input type="hidden" name="search" value="{{ $search }}"><input type="hidden" name="after" value="{{ $before }}"><button class="view-btn">← Prev</button></form>
        @endif

        @if($after)
            <form method="GET"><input type="hidden" name="search" value="{{ $search }}"><input type="hidden" name="after" value="{{ $after }}"><button class="view-btn">Next →</button></form>
        @endif
    </div>

    <footer>
        Showing {{ number_format(count($posts)) }} posts • Total reported: {{ number_format($totalPosts) }}
    </footer>

</div>

</body>
</html>
