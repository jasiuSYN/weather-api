<?php

declare(strict_types=1);

namespace App\Model;

class Localization
{
    public function __construct(
        private string $address,
        private Coordinates $coordinates,
        private array $types
    ) {}

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function setCoordinates(Coordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function setTypes(array $types): void
    {
        $this->types = $types;
    }
}