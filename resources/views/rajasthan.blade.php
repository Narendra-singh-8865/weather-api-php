<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rajasthan की ताज़ा खबरें</title>
    <link rel="stylesheet" href="css/news.css">
</head>
<body>
@php  use Illuminate\Support\Str; @endphp
    <nav>
        <a href="news">Madhya Pradesh (MP)</a>
        <a href="">Neemuch</a>
        <a href="">Mandsaur</a>
        <a href="">Pratapgarh</a>
    </nav>

    <h1 class="title">Rajasthan की ताज़ा खबरें</h1>
    <div class="btn-group">
    </div>
    <div class="news-list">
        @foreach($newsItems as $newsItem)
            <div class="news-card">
                <img src="{{ $newsItem->image_url }}" alt="News Image" class="news-image">
                <div class="news-content">
                    <h2 class="news-title">{{ trim($newsItem->title) }}</h2>
                    <p class="news-description">{{ $newsItem->description }}</p>
                    <p>Published: {{ \Carbon\Carbon::parse($newsItem->published_at)->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>
