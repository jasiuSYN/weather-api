<?php

declare(strict_types=1);

namespace App\Client\Geocode\DataTransformer;

use App\Model\Coordinates;
use App\Model\Localization;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GoogleGeocodeToLocalizationTransformer
{
    /**
     * @return Localization[]
     */
    public function transformFromGeocodeApi(ResponseInterface $response): array
    {
        $data = $response->toArray();

        $localizations = [];

        foreach ($data['results'] as $value)
        {
            $localization = new Localization(
                name: $value['formatted_address'],
                coordinates: new Coordinates(
                    latitude: (string)$value['geometry']['location']['lat'],
                    longitude: (string)$value['geometry']['location']['lng']
                    ),
                types: $value['types']
            );
            $localizations[] = $localization;
        }
        return $localizations;
    }
}