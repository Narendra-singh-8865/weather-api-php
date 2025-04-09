<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Services\WeatherServices;
use Illuminate\Support\Facades\DB;

class IndController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherServices $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function state()
    {
        $states = State::all();
        return view('Countryall', compact('states'));
    }

    public function city(Request $request)
    {
        $request->validate([
            'state_code' => 'required|exists:states,code',
        ]);

        $state_code = $request->state_code;
        $states = State::all();

        $cities = City::where('state_code', $state_code)->get();

        return view('Countryall', compact('states', 'cities', 'state_code'));
    }

    public function getWeathers(Request $request)
    {
        $cityInput = $request->input('city', 'London');

        $cityData = DB::table('citys')
            ->join('states', 'citys.state_code', '=', 'states.code')
            ->select('citys.city as city_name', 'states.name as state_name')
            ->where('citys.city', $cityInput)
            ->first();
        if (!$cityData) {
            return back()->with('error', "City not found in database. Please check the city name.");
        }
        $weatherData = $this->weatherService->getWeather($cityData->city_name);
        if (!$weatherData) {
            return back()->with('error', "Unable to fetch weather data for " . ucwords($cityInput) . ". Please try again later.");
        }
        $cityName = $cityData->city_name;
        $stateName = $cityData->state_name;
        $dates = [];
        $temps = [];
        if (isset($weatherData['list'])) {
            foreach ($weatherData['list'] as $forecast) {
                $date = \Carbon\Carbon::createFromTimestamp($forecast['dt'])->format('d M Y');
                $dates[] = $date;
                $temperature = $forecast['main']['temp'];
                $temps[] = round($temperature, 0);
            }
        }
        $states = State::all();
        $cities = City::where('state_code', $request->state_code)->get();
        return view('Countryall', compact('states', 'cities', 'cityName', 'stateName', 'dates', 'temps'));
    }
}
