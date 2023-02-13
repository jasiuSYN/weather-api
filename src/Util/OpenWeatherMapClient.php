<?php

declare(strict_types=1);

namespace App\Util;

use App\Model\Coordinates;
use App\Model\WeatherData;

use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherMapClient implements WeatherProviderClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $openWeatherMapApiKey,
        private OpenWeatherMapToWeatherDataTransformer $transformer
    ) {}

    public function fetchWeatherForCoordinates(Coordinates $coordinates): WeatherData
    {
        $response = $this->client->request('GET', 'https://api.openweathermap.org/data/2.5/weather',
            [
                'query' => [
                    'lat' => $coordinates->getLatitude(),
                    'lon' => $coordinates->getLongitude(),
                    'appid' => $this->openWeatherMapApiKey,
                    'units' => 'metric',
                ]
            ]);

        return $this->transformer->transform($response);
    }
}