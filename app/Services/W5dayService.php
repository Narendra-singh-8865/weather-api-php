<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class W5dayService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = "40ffe92c8489dd5f799ff8477c7812f9"; 
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

