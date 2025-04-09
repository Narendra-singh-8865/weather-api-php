<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\W5dayService;

class We5day extends Controller
{
    protected $weatherService;

    public function __construct(W5dayService $weatherService)
    {
        $this->weatherService = $weatherService; 
    }

    public function getWeather(Request $request)
    {
        $city = $request->get('city', 'London');
        $data = $this->weatherService->getWeather($city);
        return view('w5daydata', compact('data'));
    }
}
