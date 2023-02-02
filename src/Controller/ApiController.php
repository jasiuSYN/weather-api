<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiController
{
    public $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/api/weather-app/{localization}', name: 'app_city')]
    public function fetchLonLat(string $localization)
    {
        $apiKey = 'f984011316eeef4968086fa5d3e30181';

        $url = sprintf(
            "https://api.openweathermap.org/geo/1.0/direct?q=%s&limit=5&appid=%s",
            ucwords($localization),
            $apiKey);

        $response = $this->client->request('GET', $url);

        $statusCode = $response->getStatusCode();

//        $content = $response->getContent();

        return $statusCode;
    }
}
