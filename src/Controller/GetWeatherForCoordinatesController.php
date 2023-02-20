<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\Weather\WeatherProviderClientInterface;
use App\Model\Coordinates;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class GetWeatherForCoordinatesController extends AbstractController
{
    public function __construct(private WeatherProviderClientInterface $client) {}

    #[Route('/api/weather-by-coordinates', name: 'weather-coordinates')]
    public function __invoke(Request $request, SerializerInterface $serializer, ObjectNormalizer $normalizer): JsonResponse
    {
        $coordinates = $normalizer->denormalize($request->query->all(), Coordinates::class);

        $weatherData = $this->client->fetchWeatherForCoordinates($coordinates);

        return JsonResponse::fromJsonString($serializer->serialize($weatherData, 'json'));
    }
}