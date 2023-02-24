<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Coordinates
{
    #[Assert\NotBlank(
        message: 'WEATHER_REQUEST_PARAMETER_IS_EMPTY'
    )]
    #[Assert\Range(
        notInRangeMessage: 'WEATHER_REQUEST_LATITUDE_IS_OUT_OF_RANGE',
        invalidMessage: 'WEATHER_REQUEST_PARAMETER_IS_NOT_VALID_NUMBER',
        min: -90,
        max: 90
    )]
    private string $latitude;
    #[Assert\NotBlank(
        message: 'WEATHER_REQUEST_PARAMETER_IS_EMPTY'
    )]
    #[Assert\Range(
        notInRangeMessage: 'WEATHER_REQUEST_LONGITUDE_IS_OUT_OF_RANGE',
        invalidMessage: 'WEATHER_REQUEST_PARAMETER_IS_NOT_VALID_NUMBER',
        min: -180,
        max: 180
    )]
    private string $longitude;
    public function __construct(string $latitude, string $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }
}