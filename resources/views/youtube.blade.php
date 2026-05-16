<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube — D'Kampong Pizza</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif;}
        body{background:#f8fafc;color:#0f172a;line-height:1.6;}
        .frame{max-width:1000px;margin:0 auto;padding:32px 22px;}
        header{display:flex;flex-direction:column;gap:10px;padding-bottom:28px;border-bottom:1px solid #e2e8f0;}
        .brand{display:flex;align-items:center;gap:12px;font-weight:700;color:#0f172a;font-size:20px;}
        .brand span{font-size:24px;}
        .sub{color:#475569;font-size:14px;max-width:600px;}

        .search-panel{display:grid;gap:16px;margin:28px 0;padding:22px;border:1px solid #e2e8f0;border-radius:18px;background:#ffffff;}
        .search-panel .meta{display:flex;flex-wrap:wrap;gap:8px;color:#64748b;font-size:13px;}
        .search-panel form{display:flex;gap:10px;flex-wrap:wrap;}
        .search-panel input{flex:1;min-width:220px;padding:12px 14px;border:1px solid #cbd5e1;border-radius:12px;background:#f8fafc;}
        .search-panel button{padding:12px 18px;border:none;background:#0f172a;color:white;border-radius:12px;cursor:pointer;font-weight:600;}

        .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin:20px 0;}
        .stat-card{padding:18px;border-radius:16px;border:1px solid #e2e8f0;background:#fff;}
        .stat-card h2{font-size:24px;color:#0f172a;margin-bottom:8px;}
        .stat-card p{color:#64748b;font-size:13px;}

        .grid{display:grid;grid-template-columns:1fr;gap:18px;}
        .panel{padding:20px;border-radius:18px;background:#fff;border:1px solid #e2e8f0;}
        .panel h3{font-size:16px;font-weight:600;color:#0f172a;margin-bottom:14px;}

        .feed{display:grid;gap:20px;margin-top:26px;}
        .card{padding:20px;border-radius:18px;background:#fff;border:1px solid #e2e8f0;display:grid;gap:16px;}
        .card-header{display:flex;justify-content:space-between;align-items:flex-start;gap:14px;}
        .card-title{font-weight:600;color:#0f172a;font-size:16px;}
        .card-meta{color:#64748b;font-size:13px;display:flex;flex-wrap:wrap;gap:10px;}
        .card-body{display:grid;gap:14px;}
        .video-media{position:relative;width:100%;min-height:240px;border-radius:14px;overflow:hidden;background:#000;}
        .video-media iframe{width:100%;height:100%;border:none;}
        .card-actions{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;}
        .pill{display:inline-flex;align-items:center;padding:8px 12px;border-radius:999px;font-size:12px;background:#eef2ff;color:#1d4ed8;}
        .accent{color:#ef4444;font-weight:600;}
        .button{padding:10px 16px;border:none;border-radius:12px;background:#0f172a;color:#fff;text-decoration:none;font-weight:600;}

        .pagination{display:flex;justify-content:center;gap:10px;margin:24px 0;flex-wrap:wrap;}
        .pagination button{padding:12px 16px;border:none;border-radius:12px;background:#0f172a;color:#fff;cursor:pointer;}

        @media(max-width:640px){.frame{padding:22px 16px;} .brand{font-size:18px;} .search-panel form{flex-direction:column;} .card-header{flex-direction:column;align-items:flex-start;}}
    </style>
</head>
<body>
<div class="frame">
    <header>
        <div class="brand"><span>▶</span>D'Kampong Pizza — YouTube</div>
        <p class="sub">Minimal analytics for pizza video search, presented with calm spacing and focused clarity.</p>
    </header>

    <section class="search-panel">
        <div class="meta">Search results for <strong>{{ $search }}</strong> • Total videos: {{ number_format($totalVideos) }}</div>
        <form method="GET">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search pizza videos...">
            <button>Search</button>
        </form>
    </section>

    <div class="stats-grid">
        <div class="stat-card">
            <h2>{{ number_format($totalVideos) }}</h2>
            <p>Total videos found</p>
        </div>
        <div class="stat-card">
            <h2>{{ $platform }}</h2>
            <p>Platform insight mode</p>
        </div>
        <div class="stat-card">
            <h2>{{ $nextPageToken ? 'More available' : 'Last page' }}</h2>
            <p>Navigation state</p>
        </div>
    </div>

    <div class="grid">
        <div class="panel">
            <h3>Video engagement preview</h3>
            <canvas id="engagementChart" style="width:100%;height:240px;"></canvas>
        </div>
    </div>

    <div class="feed">
        @foreach($videos as $video)
            @php
                $videoId = $video['id'];
                $title = $video['title'];
                $channel = $video['channel'];
                $views = $video['views'];
                $likes = $video['likes'];
                $commentsCount = $video['comments'];
                $published = $video['published'];
                $isTrending = $video['trending'];
                $engagement = $video['engagement'];
            @endphp

            <article class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">{{ $title }}</div>
                        <div class="card-meta">{{ $channel }} • {{ \Carbon\Carbon::parse($published)->diffForHumans() }}</div>
                    </div>
                    @if($isTrending)
                        <span class="pill">Trending</span>
                    @endif
                </div>

                <div class="video-media">
                    <iframe
                        src="https://www.youtube.com/embed/{{ $videoId }}"
                        allowfullscreen
                        loading="lazy"
                        title="{{ $title }}">
                    </iframe>
                </div>

                <div class="card-actions">
                    <div class="card-meta">
                        <span>Views: {{ number_format($views) }}</span>
                        <span>Likes: {{ number_format($likes) }}</span>
                        <span>Comments: {{ number_format($commentsCount) }}</span>
                        <span class="accent">Engagement {{ $engagement }}%</span>
                    </div>
                    <a class="button" href="/watch_youtube/{{ $videoId }}">Watch</a>
                </div>
            </article>
        @endforeach
    </div>

    <div class="pagination">
        @if($prevPageToken)
        <form method="GET">
            <input type="hidden" name="search" value="{{ $search }}">
            <input type="hidden" name="pageToken" value="{{ $prevPageToken }}">
            <button>Previous</button>
        </form>
        @endif

        @if($nextPageToken)
        <form method="GET">
            <input type="hidden" name="search" value="{{ $search }}">
            <input type="hidden" name="pageToken" value="{{ $nextPageToken }}">
            <button>Next</button>
        </form>
        @endif
    </div>
</div>

<script>
    const labels = @json($chartLabels);
    const engagementData = @json($chartEngagement);
    if(labels.length > 0){
        new Chart(document.getElementById('engagementChart'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Engagement %',
                    data: engagementData,
                    borderColor: '#0f172a',
                    backgroundColor: '#0f172a',
                    tension: 0.35,
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: { ticks: { color: '#475569' }, grid: { color: '#e2e8f0' } },
                    y: { ticks: { color: '#475569' }, grid: { color: '#e2e8f0' } }
                }
            }
        });
    }
</script>
</body>
</html>
