<?php

declare(strict_types=1);

namespace App\Model;

class WeatherData
{
    public function __construct(
        private string $name,
        private Coordinates $coordinates,
        private string $weather,
        private ?string $description,
        private ?int $averageTemperature,
        private ?int $minimumTemperature,
        private ?int $maximumTemperature,
        private int $pressure,
        private int $humidity
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function setCoordinates(Coordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    public function getWeather(): string
    {
        return $this->weather;
    }

    public function setWeather(string $weather): void
    {
        $this->weather = $weather;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAverageTemperature(): int
    {
        return $this->averageTemperature;
    }

    public function setAverageTemperature(int $averageTemperature): void
    {
        $this->averageTemperature = $averageTemperature;
    }

    public function getMinimumTemperature(): int
    {
        return $this->minimumTemperature;
    }

    public function setMinimumTemperature(int $minimumTemperature): void
    {
        $this->minimumTemperature = $minimumTemperature;
    }

    public function getMaximumTemperature(): int
    {
        return $this->maximumTemperature;
    }

    public function setMaximumTemperature(int $maximumTemperature): void
    {
        $this->maximumTemperature = $maximumTemperature;
    }

    public function getPressure(): float|int
    {
        return $this->pressure;
    }

    public function setPressure(float|int $pressure): void
    {
        $this->pressure = $pressure;
    }

    public function getHumidity(): float|int
    {
        return $this->humidity;
    }

    public function setHumidity(float|int $humidity): void
    {
        $this->humidity = $humidity;
    }

    public function __toString(): string
    {
        return json_encode([
            'name' => $this->name,
            'coordinates' => [
                'latitude' => $this->coordinates->getLatitude(),
                'longitude' => $this->coordinates->getLongitude(),
            ],
            'weather' => $this->weather,
            'description' => $this->description,
            'average_temperature' => $this->averageTemperature,
            'minimum_temperature' => $this->minimumTemperature,
            'maximum_temperature' => $this->maximumTemperature,
            'pressure' => $this->pressure,
            'humidity' => $this->humidity,
        ]);
    }
}
