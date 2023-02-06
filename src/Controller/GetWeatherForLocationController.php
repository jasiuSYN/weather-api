<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetWeatherForLocationController extends AbstractController
{

    public function __construct(
        private HttpClientInterface $client,
    ) {}

    public function getContentFromUrl(string $url): array
    {
        if ($this->client->request('GET', $url)->getStatusCode() < 400){

            $response = $this->client->request('GET', $url);
            return $response->toArray();
        }

        else{
            return ['cod' => Response::HTTP_BAD_REQUEST, 'message' => 'Wrong data'];
        }
    }

    public function getWeatherArrayContext(array $data): array
    {
        $weatherData = [
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
        return $weatherData;
    }

    #[Route('/api/location', name: 'location')]
    public function __invoke(Request $request, string $openWeatherMapApiKey): JsonResponse
    {
        $lat = $request->query->get('lat');
        $lon = $request->query->get('lon');

        $url = sprintf(
            "https://api.openweathermap.org/data/2.5/weather?lat=%s&lon=%s&appid=%s&units=metric",
            $lat, $lon, $openWeatherMapApiKey
        );

        $data = $this->getContentFromUrl($url);

        if ($data['cod'] == 200) {
            $weatherData = $this->getWeatherArrayContext($data);
            return new JsonResponse($weatherData, Response::HTTP_OK);
        }

        else
            return new JsonResponse($data, Response::HTTP_BAD_REQUEST);
    }
}