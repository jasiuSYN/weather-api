<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Coordinates
{
    #[Assert\NotBlank]
    #[Assert\Range(
        min: -90,
        max: 90,
        notInRangeMessage: 'Latitude must be between {{ min }} and {{ max }}'
    )]
    private string $latitude;
    #[Assert\NotBlank]
    #[Assert\Range(
        min: -180,
        max: 180,
        notInRangeMessage: 'Longitude must be between {{ min }} and {{ max }}'
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