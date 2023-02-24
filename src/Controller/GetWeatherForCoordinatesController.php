<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\Weather\WeatherProviderClientInterface;
use App\Model\Coordinates;
use App\Model\Errors\Error;
use App\Model\Errors\ErrorList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetWeatherForCoordinatesController extends AbstractController
{
    public function __construct(private WeatherProviderClientInterface $client) {}

    #[Route('/api/weather-by-coordinates', name: 'weather-coordinates')]
    public function __invoke(Request $request, SerializerInterface $serializer, ObjectNormalizer $normalizer, ValidatorInterface $validator): JsonResponse
    {
        $coordinates = $normalizer->denormalize($request->query->all(), Coordinates::class);

        $errors = $validator->validate($coordinates);

        if ($errors->count() > 0) {

            $errorList = new ErrorList();

            foreach ($errors as $error) {

                $errorList->addError(new Error($error->getCode(), $error->getMessage()));
            }

            return JsonResponse::fromJsonString($serializer->serialize($errorList, 'json'), 400);
        }

        $weatherData = $this->client->fetchWeatherForCoordinates($coordinates);

        return JsonResponse::fromJsonString($serializer->serialize($weatherData, 'json'));
    }
}