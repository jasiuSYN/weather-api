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
use Symfony\Component\Serializer\SerializerInterface;

class GetWeatherForLocationController extends AbstractController
{
    public function __construct(private OpenWeatherMapClient $client)
    {
    }

    #[Route('/api/location', name: 'location')]
    public function __invoke(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = $request->query->all();

        $jsonData = json_encode($data);
        $coordinates = $serializer->deserialize($jsonData, Coordinates::class, 'json');

        $weatherData = $this->client->fetchWeatherForCoordinates($coordinates);

        $jsonWeatherData = $serializer->serialize($weatherData, 'json');

        return new JsonResponse($jsonWeatherData, 200);
    }
}