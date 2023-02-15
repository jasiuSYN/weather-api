<?php

declare(strict_types=1);

namespace App\Model;

class Geocode
{
    public function __construct(private string $localization) {}

    public function getLocalization(): string
    {
        return $this->localization;
    }
}