<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madhya Pradesh की ताज़ा खबरें</title>
    <link rel="stylesheet" href="{{ asset('css/mp.css') }}">
</head>  
<body>

@php  use Illuminate\Support\Str; @endphp

    <nav>
        <a href="rajasthan">Rajasthan (RJ)</a>
        <a href="">Neemuch</a>
        <a href="">Mandsaur</a>
        <a href="">Pratapgarh</a>
    </nav>

    <h1 class="title">Madhya Pradesh की ताज़ा खबरें</h1>

    <div class="container">
        @if(isset($newsItems) && count($newsItems) > 0)
            <div class="news-list">
                @foreach($newsItems as $item)
                    <div class="news-card">
                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="Image" />
                        @endif
                        <h2>{{ $item->title }}</h2>
                        <p>{{ $item->description }}</p>
                        <p>Published: {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y, h:i A') }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p>कोई खबर उपलब्ध नहीं है।</p>
        @endif
    </div>

</body>
</html>
