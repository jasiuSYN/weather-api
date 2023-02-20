<?php

declare(strict_types=1);

namespace App\Client\Weather\Tomorrow;

use App\Client\Weather\Tomorrow\DataTransformer\TomorrowToWeatherDataTransformer;
use App\Client\Weather\WeatherProviderClientInterface;
use App\Model\Coordinates;
use App\Model\WeatherData;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client implements WeatherProviderClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $tomorrowApiKey,
        private TomorrowToWeatherDataTransformer $transformer
    ) {}

    public function fetchWeatherForCoordinates(Coordinates $coordinates): WeatherData
    {
        $response = $this->client->request('GET', 'https://api.tomorrow.io/v4/weather/realtime',
            [
                'query' => [
                    'location' => sprintf(
                        '%s, %s',
                        $coordinates->getLatitude(),
                        $coordinates->getLongitude()
                    ),
                    'units' => 'metric',
                    'apikey' => $this->tomorrowApiKey,
                ]
            ]);

        return $this->transformer->transform($response);
    }
}