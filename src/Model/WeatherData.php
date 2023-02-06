<?php

declare(strict_types=1);

namespace App\Model;

class WeatherData
{
    public $main;
    public $description;
    public $temp_avg;
    public $temp_min;
    public $temp_max;
    public $pressure;
    public $humidity;

    public function __construct(array $data) {
        $this->main = $data['weather'][0]['main'];
        $this->description = $data['weather'][0]['description'];
        $this->temp_avg = $data['main']['temp'];
        $this->temp_min = $data['main']['temp_min'];
        $this->temp_max = $data['main']['temp_max'];
        $this->pressure = $data['main']['pressure'];
        $this->humidity = $data['main']['humidity'];
    }

    /**
     * @return mixed
     */
    public function getMain(): mixed
    {
        return $this->main;
    }

    /**
     * @param mixed $main
     */
    public function setMain(mixed $main): void
    {
        $this->main = $main;
    }

    /**
     * @return mixed
     */
    public function getDescription(): mixed
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription(mixed $description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTempAvg(): mixed
    {
        return $this->temp_avg;
    }

    /**
     * @param mixed $temp_avg
     */
    public function setTempAvg(mixed $temp_avg): void
    {
        $this->temp_avg = $temp_avg;
    }

    /**
     * @return mixed
     */
    public function getTempMin(): mixed
    {
        return $this->temp_min;
    }

    /**
     * @param mixed $temp_min
     */
    public function setTempMin(mixed $temp_min): void
    {
        $this->temp_min = $temp_min;
    }

    /**
     * @return mixed
     */
    public function getTempMax(): mixed
    {
        return $this->temp_max;
    }

    /**
     * @param mixed $temp_max
     */
    public function setTempMax(mixed $temp_max): void
    {
        $this->temp_max = $temp_max;
    }

    /**
     * @return mixed
     */
    public function getPressure(): mixed
    {
        return $this->pressure;
    }

    /**
     * @param mixed $pressure
     */
    public function setPressure(mixed $pressure): void
    {
        $this->pressure = $pressure;
    }

    /**
     * @return mixed
     */
    public function getHumidity(): mixed
    {
        return $this->humidity;
    }

    /**
     * @param mixed $humidity
     */
    public function setHumidity(mixed $humidity): void
    {
        $this->humidity = $humidity;
    }
}