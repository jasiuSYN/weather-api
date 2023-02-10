<?php

declare(strict_types=1);

namespace App\Util;

use App\Model\Coordinates;
use App\Model\WeatherData;

use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
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
        $url = sprintf(
            "https://api.openweathermap.org/data/2.5/weather?lat=%s&lon=%s&appid=%s&units=metric",
            $coordinates->getLatitude(), $coordinates->getLongitude(), $this->openWeatherMapApiKey
        );

        try{
            $response = $this->client->request('GET', $url);
            if (200 != $response->getStatusCode()){
                throw new BadRequestException($response->getContent(false));
            }
        } catch (BadRequestException $e) {
            echo $e->getMessage();
        }

        return $this->transformer->transform($response);
    }
}