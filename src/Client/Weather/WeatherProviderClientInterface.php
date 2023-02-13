<?php

declare(strict_types=1);

namespace App\Client\Weather;

use App\Model\Coordinates;
use App\Model\WeatherData;

interface WeatherProviderClientInterface
{
    public function fetchWeatherForCoordinates(Coordinates $coordinates): WeatherData;
}