<?php

namespace App\Client\Localizations\GoogleGeocode;

use App\Model\Geocode;

interface GoogleGeocodeProviderClientInterface
{
    public function fetchLocalizationsForGeocode(Geocode $geocode): array;
}