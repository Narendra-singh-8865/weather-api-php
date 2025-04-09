<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State & City Selection</title>
    <link rel="stylesheet" href="{{ asset('css/weather.css') }}">
</head>
<body>

<div class="container">
    <h2>Select State & City</h2>

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

        <form action="{{ url('/city') }}" method="post">
        @csrf
        <label for="state">Select State:</label>
        <select name="state_code" id="state" required>
            <option value="">-- Select State --</option>
            @foreach($states as $state)
                <option value="{{ $state->code }}" {{ isset($state_code) && $state_code == $state->code ? 'selected' : '' }}>
                    {{ $state->name }}
                </option>
            @endforeach
        </select>
        <button type="submit">Show Cities</button>
    </form>

    @if(isset($cities) && $cities->count() > 0)
        <h3>Available Cities:</h3>
        <form action="{{ url('/getWeathers') }}" method="post">
            @csrf
            <label for="city">Select City:</label>
            <select name="city" id="city" required>
                <option value="">-- Select City --</option>
                @foreach($cities as $city)
                    <option value="{{ $city->city }}">{{ $city->city }}</option>
                @endforeach
            </select>
            <button type="submit">Get Weather</button>
        </form>
    @endif
</div>

@if(isset($cityName))
    <div class="weather-container">
        <h1>Weather in {{ $cityName }} ({{ $stateName ?? '' }})</h1>
        <h3>7-Day Temperature Data</h3>

        <div class="line-graph-container">
            <svg width="100%" height="300">
                @php
                    if(count($temps) > 0) {
                        $minTemp = min($temps);
                        $maxTemp = max($temps);
                        $graphHeight = 200;
                        $graphWidth = 900;
                        $points = '';
                        $x = 0;
                        foreach($temps as $temp) {
                            $temp = max($minTemp, min($temp, $maxTemp));
                            $y = $graphHeight - (($temp - $minTemp) / ($maxTemp - $minTemp)) * $graphHeight;
                            $points .= "$x,$y ";
                            $x += $graphWidth / (count($temps) - 1);
                        }
                    } else {
                        $points = '';
                    }
                @endphp
                @if($points)
                    <polyline fill="transparent" stroke="#4CAF50" stroke-width="3" points="{{ $points }}" />
                @else
                    <text x="50%" y="50%" text-anchor="middle" fill="black" font-size="16">No data available</text>
                @endif
            </svg>
        </div>

        <h4>Dates:</h4>
        <ul>
            @foreach($dates as $date)
                <li>{{ $date }}</li>
            @endforeach
        </ul>

        <h4>Temperatures:</h4>
        <ul>
            @foreach($temps as $temp)
                <li>{{ $temp }}°C</li>
            @endforeach
        </ul>
    </div>
@endif

</body>
</html>
