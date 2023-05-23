<?php

declare(strict_types=1);

namespace App\Client\Weather\OpenWeatherMap;

use App\Client\Weather\OpenWeatherMap\DataTransformer\OpenWeatherMapToWeatherDataTransformer;
use App\Client\Weather\WeatherProviderClientInterface;

use App\Model\Coordinates;
use App\Model\WeatherData;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client implements WeatherProviderClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $openWeatherMapApiKey,
        private OpenWeatherMapToWeatherDataTransformer $transformer
    ) {
    }

    public function fetchWeatherForCoordinates(Coordinates $coordinates): WeatherData
    {
        $response = $this->client->request(
            method: 'GET',
            url: 'https://api.openweathermap.org/data/2.5/weather',
            options: [
                'query' => [
                    'lat' => $coordinates->getLatitude(),
                    'lon' => $coordinates->getLongitude(),
                    'appid' => $this->openWeatherMapApiKey,
                    'units' => 'metric',
                ]
            ]
        );
        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Failed to fetch weather data');
        }

        return $this->transformer->transform($response);
    }

    public function fetchLocalizationName(string $latitude, string $longitude): string
    {
        $response = $this->client->request(
            method: 'GET',
            url: 'https://api.openweathermap.org/data/2.5/weather',
            options: [
                'query' => [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'appid' => $this->openWeatherMapApiKey,
                    'units' => 'metric',
                ]
            ]
        );

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Failed to fetch localization name');
        }

        return $response->toArray()['name'];
    }
}
