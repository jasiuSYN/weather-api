<?php

declare(strict_types=1);

namespace App\Model\NotificationDefinition;

use Symfony\Component\Validator\Constraints as Assert;

class AddNotificationDefinitionInput
{
    #[Assert\NotBlank(message: 'EMAIL_IS_REQUIRED.')]
    #[Assert\Email(message: 'INVALID_EMAIL_FORMAT.')]
    private string $email;

    #[Assert\NotBlank(
        message: 'WEATHER_REQUEST_LATITUDE_IS_EMPTY'
    )]
    #[Assert\Range(
        notInRangeMessage: 'WEATHER_REQUEST_LATITUDE_IS_OUT_OF_RANGE',
        invalidMessage: 'WEATHER_REQUEST_INVALID_LATITUDE_VALUE',
        min: -90,
        max: 90
    )]
    private string $latitude;

    #[Assert\NotBlank(
        message: 'WEATHER_REQUEST_LONGITUDE_IS_EMPTY'
    )]
    #[Assert\Range(
        notInRangeMessage: 'WEATHER_REQUEST_LONGITUDE_IS_OUT_OF_RANGE',
        invalidMessage: 'WEATHER_REQUEST_INVALID_LONGITUDE_VALUE',
        min: -180,
        max: 180
    )]
    private string $longitude;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }

    public static function fromArray(array $data): self
    {
        $input = new self();
        $input->setEmail($data['email']);
        $input->setLatitude((string)$data['coordinates']['latitude']);
        $input->setLongitude((string)$data['coordinates']['longitude']);

        return $input;
    }
}