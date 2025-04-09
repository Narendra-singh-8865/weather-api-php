<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class WeatherServices
{
    protected $client;
    protected $apiKey;
    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.openweathermap.api_key'); 
    }

    public function getWeather($city)
    {
        $url = "https://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$this->apiKey}&units=metric";

        try {
            $response = $this->client->get($url);
            $data = json_decode($response->getBody()->getContents(), true);

            return $data; 
        } catch (Exception $e) {
            return ['error' => 'Failed to fetch weather data', 'message' => $e->getMessage()];
        }
    }
}


