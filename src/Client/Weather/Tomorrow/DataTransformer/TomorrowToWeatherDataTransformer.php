<?php

declare(strict_types=1);

namespace App\Client\Weather\Tomorrow\DataTransformer;

use App\Model\Coordinates;
use App\Model\WeatherData;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TomorrowToWeatherDataTransformer
{
    private static array $weatherCode = [
        "0" => 'Unknown',
        '1000' => "Clear, Sunny",
        '1100' => 'Mostly Clear',
        '1101' => 'Partly Cloudy',
        '1102' => 'Mostly Cloudy',
        '1001' => 'Cloudy',
        '2000' => 'Fog',
        '2100' => 'Light Fog',
        '4000' => 'Drizzle',
        '4001' => 'Rain',
        '4200' => 'Light Rain',
        '4201' => 'Heavy Rain',
        '5000' => 'Snow',
        '5001' => 'Flurries',
        '5100' => 'Light Snow',
        '5101' => 'Heavy Snow',
        '6000' => 'Freezing Drizzle',
        '6001' => 'Freezing Rain',
        '6200' => 'Light Freezing Rain',
        '6201' => 'Heavy Freezing Rain',
        '7000' => 'Ice Pellets',
        '7101' => 'Heavy Ice Pellets',
        '7102' => 'Light Ice Pellets',
        '8000' => 'Thunderstorm',
];

private function roundToInt(float|int|null $value): ?int
    {
        return $value !== null ? (int)round($value) : null;
    }

    private function getWeatherDescription(int $code): string
    {
        if (self::$weatherCode[(string)$code])
            return self::$weatherCode[$code];
        return (string)$code;
    }
    public function transform(ResponseInterface $response): WeatherData
    {
        $data = $response->toArray();

        return new WeatherData(
            name: $data['location']['name'] ?? "",
            coordinates: new Coordinates((string)$data['location']['lat'], (string)$data['location']['lon']),
            weather: $this->getWeatherDescription($data['data']['values']['weatherCode']),
            description: "",
            averageTemperature: $this->roundToInt($data['data']['values']['temperature']) ?? null,
            minimumTemperature: null,
            maximumTemperature: null,
            pressure: $data['data']['values']['pressureSurfaceLevel'],
            humidity: $data['data']['values']['humidity']
        );
    }
}