<?php

namespace App\Client\Geocode;

use App\Model\GeocodeRequest;

interface GeocodeProviderClientInterface
{
    public function geocode(GeocodeRequest $geocode): array;
}