<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\Localizations\GoogleGeocode\GoogleClient;
use App\Model\Geocode;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class GetLocalizationsForGeocodeController extends AbstractController
{
    public function __construct(private GoogleClient $client) {}

    #[Route('api/localizations-for-geocode', name: 'localizations-geocode')]
    public function __invoke(Request $request, SerializerInterface $serializer, ObjectNormalizer $normalizer): JsonResponse
    {
        $geocode = $normalizer->denormalize($request->query->all(), Geocode::class);

        $localizationsData = $this->client->fetchLocalizationsForGeocode($geocode);

        return JsonResponse::fromJsonString($serializer->serialize($localizationsData, 'json'));
    }
}