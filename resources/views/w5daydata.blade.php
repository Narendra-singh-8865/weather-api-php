<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5-Day Weather Forecast</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Weather Form -->
        <form action="{{ url('/weathersday') }}" method="get">
            <div class="form-group">
                <label for="city">Enter City:</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="Enter city name" required>
            </div>
            <button type="submit" class="btn btn-primary">Get Weather</button>
        </form>

        <h2 class="mt-4">5-Day Weather Forecast</h2>

        @if(isset($data['error']))
            <div class="alert alert-danger">
                {{ $data['message'] }}
            </div>
        @else
            @php
                $previousDay = null;
            @endphp

            <div class="row">
                @foreach($data['list'] as $forecast)
                    @php
                       
                        $date = \Carbon\Carbon::createFromTimestamp($forecast['dt'])->format('Y-m-d');
                    @endphp

                    @if ($previousDay != $date)
                 
                        @php $previousDay = $date; @endphp
                        <div class="col-12">
                            <h3>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('l, F j, Y') }}</h3>
                        </div>
                    @endif

                    <div class="col-md-2">
                        <div class="card mb-4">
                            <img src="http://openweathermap.org/img/wn/{{ $forecast['weather'][0]['icon'] }}@2x.png" class="card-img-top" alt="Weather Icon">
                            <div class="card-body">
                                <h5 class="card-title">{{ $forecast['main']['temp'] }}&deg;C</h5>
                                <p class="card-text">{{ $forecast['weather'][0]['description'] }}</p>
                                <p class="card-text"><strong>Humidity:</strong> {{ $forecast['main']['humidity'] }}%</p>
                                <p class="card-text"><strong>Pressure:</strong> {{ $forecast['main']['pressure'] }} hPa</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
