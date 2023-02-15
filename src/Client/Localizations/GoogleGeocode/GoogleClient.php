<?php

declare(strict_types=1);

namespace App\Client\Localizations\GoogleGeocode;

use App\Client\Localizations\GoogleGeocode\DataTransformer\GoogleGeocodeToLocalizationTransformer;
use App\Model\Geocode;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GoogleClient implements GoogleGeocodeProviderClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $googleMapsApiKey,
        private GoogleGeocodeToLocalizationTransformer $transformer
    ) {}
    public function fetchLocalizationsForGeocode(Geocode $geocode): array
    {
        $response = $this->client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json',
            [
                'query' => [
                    'address' => $geocode->getLocalization(),
                    'key' => $this->googleMapsApiKey
                ]
            ]);

        return $this->transformer->transformFromGeocodeApi($response);
    }
}