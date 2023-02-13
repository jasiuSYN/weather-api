<?php

namespace App\Client\Weather;

use App\Model\Coordinates;
use App\Model\WeatherData;

interface WeatherProviderClientInterface
{
    public function fetchWeatherForCoordinates(Coordinates $coordinates): WeatherData;
}