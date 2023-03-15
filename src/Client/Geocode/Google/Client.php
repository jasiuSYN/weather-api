<?php

declare(strict_types=1);

namespace App\Client\Geocode\Google;

use App\Client\Geocode\DataTransformer\GoogleGeocodeToLocalizationTransformer;
use App\Client\Geocode\GeocodeProviderClientInterface;
use App\Model\GeocodeRequest;
use App\Model\Localization;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client implements GeocodeProviderClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $googleMapsApiKey,
        private GoogleGeocodeToLocalizationTransformer $transformer
    ) {
    }

    /**
     * @return Localization[]
     */
    public function geocode(GeocodeRequest $geocode): array
    {
        $response = $this->client->request(
            'GET',
            'https://maps.googleapis.com/maps/api/geocode/json',
            [
                'query' => [
                    'address' => $geocode->getLocalization(),
                    'key' => $this->googleMapsApiKey
                ]
            ]
        );

        return $this->transformer->transformFromGeocodeApi($response);
    }
}
