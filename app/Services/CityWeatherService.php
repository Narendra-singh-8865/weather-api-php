<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CityWeatherService
{
    protected $apiKey = '40ffe92c8489dd5f799ff8477c7812f9'; // Your OpenWeather API key

    public function getWeather($city)
    {
        // First, get latitude and longitude of the city using the "weather" API endpoint
        $cityData = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric', // Convert temperatures to Celsius
        ]);

        if ($cityData->failed()) {
            return null; // Return null if city data request fails
        }

        $cityData = $cityData->json();
        $lat = $cityData['coord']['lat'];
        $lon = $cityData['coord']['lon'];

        // Fetch the 7-day weather forecast using One Call API
        $forecastData = Http::get("https://api.openweathermap.org/data/2.5/onecall", [
            'lat' => $lat,
            'lon' => $lon,
            'exclude' => 'current,minutely,hourly,alerts', // Exclude unnecessary data
            'appid' => $this->apiKey,
            'units' => 'metric', // Celsius
        ]);

        if ($forecastData->failed()) {
            return null; // Return null if forecast data request fails
        }

        return $forecastData->json(); // Return the forecast data
    }
}
