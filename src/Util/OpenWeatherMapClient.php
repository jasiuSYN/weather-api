<?php

declare(strict_types=1);

namespace App\Util;

use App\Model\Coordinates;
use App\Model\WeatherData;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherMapClient implements WeatherProviderClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $openWeatherMapApiKey
    ) {}

    public function fetchWeatherForCoordinates(Coordinates $coordinates): WeatherData
    {
        $latitude = $coordinates->getLatitude();
        $longitude = $coordinates->getLongitude();

        $url = sprintf(
            "https://api.openweathermap.org/data/2.5/weather?lat=%s&lon=%s&appid=%s&units=metric",
            $latitude, $longitude, $this->openWeatherMapApiKey
        );

        try {
            $responseData = $this->client->request('GET', $url)->toArray();
        } catch (ClientExceptionInterface $e) {
            error_log($e->getMessage());
        }
        return new WeatherData($responseData);
    }
}