<?php

declare(strict_types=1);

namespace App\Model;

class WeatherData
{
    public function __construct(
        private $localization,
        private $main,
        private $description,
        private $averageTemperature,
        private $minimumTemperature,
        private $maximumTemperature,
        private $pressure,
        private $humidity
    ) {}

    /**
     * @return mixed
     */
    public function getLocalization()
    {
        return $this->localization;
    }

    /**
     * @param mixed $localization
     */
    public function setLocalization($localization): void
    {
        $this->localization = $localization;
    }

    /**
     * @return mixed
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * @param mixed $main
     */
    public function setMain($main): void
    {
        $this->main = $main;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAverageTemperature()
    {
        return $this->averageTemperature;
    }

    /**
     * @param mixed $averageTemperature
     */
    public function setAverageTemperature($averageTemperature): void
    {
        $this->averageTemperature = $averageTemperature;
    }

    /**
     * @return mixed
     */
    public function getMinimumTemperature()
    {
        return $this->minimumTemperature;
    }

    /**
     * @param mixed $minimumTemperature
     */
    public function setMinimumTemperature($minimumTemperature): void
    {
        $this->minimumTemperature = $minimumTemperature;
    }

    /**
     * @return mixed
     */
    public function getMaximumTemperature()
    {
        return $this->maximumTemperature;
    }

    /**
     * @param mixed $maximumTemperature
     */
    public function setMaximumTemperature($maximumTemperature): void
    {
        $this->maximumTemperature = $maximumTemperature;
    }

    /**
     * @return mixed
     */
    public function getPressure()
    {
        return $this->pressure;
    }

    /**
     * @param mixed $pressure
     */
    public function setPressure($pressure): void
    {
        $this->pressure = $pressure;
    }

    /**
     * @return mixed
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * @param mixed $humidity
     */
    public function setHumidity($humidity): void
    {
        $this->humidity = $humidity;
    }
}