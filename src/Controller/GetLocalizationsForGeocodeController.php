<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\Geocode\GeocodeProviderClientInterface;
use App\Model\GeocodeRequest;
use App\Response\ApiResponse;
use App\Response\NotFoundApiResponse;
use App\Response\SuccessApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class GetLocalizationsForGeocodeController extends AbstractController
{
    #[Route('api/localizations-for-geocode', name: 'localizations-geocode')]
    public function __invoke(
        Request $request,
        ObjectNormalizer $normalizer,
        GeocodeProviderClientInterface $client
    ): ApiResponse {
        $geocodeRequest = $normalizer->denormalize($request->query->all(), GeocodeRequest::class);

        $localizationsData = $client->geocode($geocodeRequest);

        if ($localizationsData === []) {
            return new NotFoundApiResponse(error: ["code" => "not_found"]);
        }

        return new SuccessApiResponse($localizationsData);
    }
}
