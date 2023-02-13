<?php

declare(strict_types=1);

namespace App\Client\Weather\OpenWeatherMap\DataTransformer;

use App\Model\WeatherData;
use Symfony\Contracts\HttpClient\ResponseInterface;

class OpenWeatherMapToWeatherDataTransformer
{
    public function transform(ResponseInterface $response): WeatherData
    {
        $data = $response->toArray();

        return new WeatherData(
            name: $data['name'],
            coordinates: $data['coord'],
            weather: $data['weather'][0]['main'],
            description: $data['weather'][0]['description'],
            averageTemperature: $data['main']['temp'],
            minimumTemperature: $data['main']['temp_min'],
            maximumTemperature: $data['main']['temp_max'],
            pressure: $data['main']['pressure'],
            humidity: $data['main']['humidity']
        );
    }
}