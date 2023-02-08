<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Localization;
use App\Util\OpenWeatherMapClient;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetWeatherForLocationController extends AbstractController
{
    public function __construct(private OpenWeatherMapClient $client) {}

    #[Route('/api/weather/location', name: 'weather-location')]
    public function __invoke(Request $request, SerializerInterface $serializer): Response
    {
        $data = $request->query->all();

        $jsonData = json_encode($data);

        $localization = $serializer->deserialize($jsonData, Localization::class, 'json');

        $weatherData = $this->client->fetchWeatherForCityName($localization);

        $jsonWeatherData = $serializer->serialize($weatherData, 'json');

        return new JsonResponse($jsonWeatherData, 200, [], true);
    }
}