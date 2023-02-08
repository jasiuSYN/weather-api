<?php

namespace App\Util;

use App\Model\Coordinates;
use App\Model\Localization;
use App\Model\WeatherData;

interface WeatherProviderClientInterface
{
    public function fetchWeatherForCoordinates(Coordinates $coordinates): WeatherData;

    public function fetchWeatherForCityName(Localization $localization): WeatherData;
}