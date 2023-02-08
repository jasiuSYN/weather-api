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
        $transformer = new OpenWeatherMapToWeatherDataTransformer();

        $url = sprintf(
            "https://api.openweathermap.org/data/2.5/weather?lat=%s&lon=%s&appid=%s&units=metric",
            $coordinates->getLatitude(), $coordinates->getLongitude(), $this->openWeatherMapApiKey
        );

        try {
            $responseData = $this->client->request('GET', $url)->toArray();
        }
        catch (ClientExceptionInterface $e) {
            error_log($e->getMessage());
        }

        return $transformer->transform($responseData);
    }
}