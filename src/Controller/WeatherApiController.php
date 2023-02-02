<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherApiController extends AbstractController
{
    private $client;

    const APIKEY = 'f984011316eeef4968086fa5d3e30181';


    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getContentFromUrl(string $url): array
    {
        $response = $this->client->request('GET', $url);

        return $response->toArray();

    }
    public function fetchLonLat(string $city): JsonResponse
    {

        $url = sprintf(
            "https://api.openweathermap.org/geo/1.0/direct?q=%s&limit=1&appid=%s",
            ucwords($city),
            self::APIKEY);

        $data = $this->getContentFromUrl($url);

        if (!empty($data))
            $coordinates = array('lat'=> $data[0]['lat'], 'lon' => $data[0]['lon']);
        else
            return new JsonResponse(
                ['code' => Response::HTTP_BAD_REQUEST, 'message' => 'City not found'],
                Response::HTTP_BAD_REQUEST);

        return new JsonResponse($coordinates, Response::HTTP_OK);
    }

    #[Route('/api/weather', name: 'weather')]
    public function weatherForLocation(Request $request): JsonResponse
    {
        $city = $request->query->get('city');

        $content = $this->fetchLonLat($city)->getContent();

        $coordinates = json_decode($content, true);

        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/weather?lat=%s&lon=%s&appid=%s&units=metric',
            $coordinates['lat'], $coordinates['lon'], self::APIKEY
        );

        $data = $this->getContentFromUrl($url);

        $weatherData = [
            'city' => ucwords($city),
            'weather' => [
                'main' => $data['weather'][0]['main'],
                'description' => $data['weather'][0]['description']
            ],
            'temp' => [
                'temp_avg' => $data['main']['temp'],
                'temp_min' => $data['main']['temp_min'],
                'temp_max' => $data['main']['temp_max']
            ],
            'pressure' => $data['main']['pressure'],
            'humidity' => $data['main']['humidity'],
        ];

        return new JsonResponse($weatherData, Response::HTTP_OK);
    }
}

