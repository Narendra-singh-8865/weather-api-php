<?php 
namespace App\Http\Controllers;

use App\Services\WeatherServices;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherServices $weatherService)
    {
        $this->weatherService = $weatherService;
    }
    public function getWeather(Request $request)
    {
        $city = $request->input('city' , 'indore');
        if (is_numeric($city) && strlen($city) == 6) {
            $weatherData = $this->weatherService->getWeather($city);
        } else {
            $weatherData = $this->weatherService->getWeather($city);
        }
        if ($weatherData && isset($weatherData['name'], $weatherData['main']['temp'], $weatherData['weather'][0]['description'])) {
            $temp = round($weatherData['main']['temp'] - 273.15, 0);
            return response()->json([
                'city' => $weatherData['name'],
                'temperature' => $temp . "°C",
                'description' => $weatherData['weather'][0]['description'],
                'date' => date('d M Y')
            ]);
         }
        if (!is_numeric($city)) {
            return response()->json([
                'error' => "Unable to fetch weather data. Please check the city name " . ucwords($city) . " or try again later.",
            ], 400);
        } else {
            return response()->json([
                'error' => "Unable to fetch weather data. Please check the city Pin Code " . $city . " or try again later.",
            ], 400);
        }
    }
}
