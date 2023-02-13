<?php

declare(strict_types=1);

namespace App\Client\Weather\OpenWeatherMap\DataTransformer;

use App\Model\Coordinates;
use App\Model\WeatherData;
use Symfony\Contracts\HttpClient\ResponseInterface;

class OpenWeatherMapToWeatherDataTransformer
{
    private function roundToInt(float|int|null $value): ?int
    {
        return $value !== null ? (int)round($value) : null;
    }

    public function transform(ResponseInterface $response): WeatherData
    {
        $data = $response->toArray();

        return new WeatherData(
            name: $data['name'],
            coordinates: new Coordinates($data['coord']['lat'], $data['coord']['lon']),
            weather: $data['weather'][0]['main'],
            description: $data['weather'][0]['description'],
            averageTemperature: $this->roundToInt($data['main']['temp']) ?? null,
            minimumTemperature: $this->roundToInt($data['main']['temp_min']) ?? null,
            maximumTemperature: $this->roundToInt($data['main']['temp_max']) ?? null,
            pressure: $data['main']['pressure'],
            humidity: $data['main']['humidity']
        );
    }
}