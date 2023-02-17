<?php

namespace App\Client\Geocode;

use App\Model\GeocodeRequest;
use App\Model\Localization;

interface GeocodeProviderClientInterface
{
    /**
     * @return Localization[]
     */
    public function geocode(GeocodeRequest $geocode): array;
}