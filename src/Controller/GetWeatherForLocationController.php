<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Coordinates;
use App\Util\OpenWeatherMapClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetWeatherForLocationController extends AbstractController
{

    public function __construct(private OpenWeatherMapClient $client) {}

    #[Route('/api/location', name: 'location')]
    public function __invoke(Request $request): JsonResponse
    {
        $latitude = $request->query->get('lat');
        $longitude = $request->query->get('lon');
        $coordinates = new Coordinates($latitude, $longitude);

        $data = $this->client->fetchWeatherForCoordinates($coordinates);
        
        return new JsonResponse([
            'main' => $data->getMain(),
            'description' => $data->getDescription(),
            'temp' => $data->getTempAvg(),
        ],
        Response::HTTP_OK);
    }


//    private function getContentFromUrl(string $url): array
//    {
//        if ($this->client->request('GET', $url)->getStatusCode() < 400){
//
//            $response = $this->client->request('GET', $url);
//            return $response->toArray();
//        }
//
//        else{
//            return ['cod' => Response::HTTP_BAD_REQUEST, 'message' => 'Wrong data'];
//        }
//    }

//    private function getWeatherArrayContext(array $data): array
//    {
//        $weatherData = [
//            'weather' => [
//                'main' => $data['weather'][0]['main'],
//                'description' => $data['weather'][0]['description']
//            ],
//            'temp' => [
//                'temp_avg' => $data['main']['temp'],
//                'temp_min' => $data['main']['temp_min'],
//                'temp_max' => $data['main']['temp_max']
//            ],
//            'pressure' => $data['main']['pressure'],
//            'humidity' => $data['main']['humidity'],
//        ];
//        return $weatherData;
//    }
}