<?php

declare(strict_types=1);

namespace App\Model;

class WeatherData
{
    public function __construct(
        private string $name,
        private array $coordinates,
        private string $weather,
        private string $description,
        private int|float $averageTemperature,
        private int|float $minimumTemperature,
        private int|float $maximumTemperature,
        private int|float $pressure,
        private int|float $humidity
    ) {}

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    /**
     * @param array $coordinates
     */
    public function setCoordinates(array $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    /**
     * @return string
     */
    public function getWeather(): string
    {
        return $this->weather;
    }

    /**
     * @param string $weather
     */
    public function setWeather(string $weather): void
    {
        $this->weather = $weather;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float|int
     */
    public function getAverageTemperature(): float|int
    {
        return $this->averageTemperature;
    }

    /**
     * @param float|int $averageTemperature
     */
    public function setAverageTemperature(float|int $averageTemperature): void
    {
        $this->averageTemperature = $averageTemperature;
    }

    /**
     * @return float|int
     */
    public function getMinimumTemperature(): float|int
    {
        return $this->minimumTemperature;
    }

    /**
     * @param float|int $minimumTemperature
     */
    public function setMinimumTemperature(float|int $minimumTemperature): void
    {
        $this->minimumTemperature = $minimumTemperature;
    }

    /**
     * @return float|int
     */
    public function getMaximumTemperature(): float|int
    {
        return $this->maximumTemperature;
    }

    /**
     * @param float|int $maximumTemperature
     */
    public function setMaximumTemperature(float|int $maximumTemperature): void
    {
        $this->maximumTemperature = $maximumTemperature;
    }

    /**
     * @return float|int
     */
    public function getPressure(): float|int
    {
        return $this->pressure;
    }

    /**
     * @param float|int $pressure
     */
    public function setPressure(float|int $pressure): void
    {
        $this->pressure = $pressure;
    }

    /**
     * @return float|int
     */
    public function getHumidity(): float|int
    {
        return $this->humidity;
    }

    /**
     * @param float|int $humidity
     */
    public function setHumidity(float|int $humidity): void
    {
        $this->humidity = $humidity;
    }
}