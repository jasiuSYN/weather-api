<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\Weather\WeatherProviderClientInterface;
use App\Model\Coordinates;
use App\Model\Errors\Error;
use App\Model\Errors\ErrorsList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetWeatherForCoordinatesController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ObjectNormalizer $normalizer,
        private ValidatorInterface $validator,
        private WeatherProviderClientInterface $client) {}

    #[Route('/api/weather-by-coordinates', name: 'weather-coordinates')]
    public function __invoke(Request $request): JsonResponse
    {
        $coordinates = $this->normalizer->denormalize($request->query->all(), Coordinates::class);

        $errors = $this->validator->validate($coordinates);

        if ($errors->count() > 0) {

            $errorList = new ErrorsList();

            foreach ($errors as $error) {

                $errorList->addError(
                    new Error($error->getMessage(),
                        null,
                        $error->getPropertyPath())
                );
            }

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($errorList, 'json'),
                $errorList->getHttpStatusCode()
            );
        }

        $weatherData = $this->client->fetchWeatherForCoordinates($coordinates);

        return JsonResponse::fromJsonString($this->serializer->serialize($weatherData, 'json'));
    }
}