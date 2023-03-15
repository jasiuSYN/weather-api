<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\Weather\WeatherProviderClientInterface;
use App\Model\Coordinates;
use App\Utility\Errors\ValidationErrorsToErrorListTransformer;
use App\Response\ApiResponse;
use App\Response\BadRequestApiResponse;
use App\Response\SuccessApiResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetWeatherForCoordinatesController extends AbstractController
{
    public function __construct(
        private ObjectNormalizer $normalizer,
        private ValidatorInterface $validator,
        private WeatherProviderClientInterface $client,
        private ValidationErrorsToErrorListTransformer $errorListTransformer
    ) {
    }

    #[Route('/api/weather-by-coordinates', name: 'weather-coordinates')]
    public function __invoke(Request $request): ApiResponse
    {
        $coordinates = $this->normalizer->denormalize($request->query->all(), Coordinates::class);

        $errors = $this->validator->validate($coordinates);

        if ($errors->count() > 0) {
            $errorList = $this->errorListTransformer->transformToErrorList($errors);

            return new BadRequestApiResponse($errorList);
        }

        $weatherData = $this->client->fetchWeatherForCoordinates($coordinates);

        return new SuccessApiResponse($weatherData);
    }
}
