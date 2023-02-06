<?php

declare(strict_types=1);

namespace App\Model;

class Coordinates
{
    public function __construct(public string $latitude, public string $longitude) {}

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }

}