<?php

declare(strict_types=1);

namespace App\EmailService;

use App\Client\Weather\OpenWeatherMap\Client;
use App\Entity\NotificationDefinition;
use App\Model\Coordinates;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class WeatherNotificationSender
{
    public function __construct(
        private MailerInterface $mailer,
        private Client $client,
    ) {
    }

    public function send(NotificationDefinition $entity): void
    {
        $weatherData = $this->client->fetchWeatherForCoordinates(
            new Coordinates(
                latitude: (string) $entity->getLatitude(),
                longitude: (string) $entity->getLongitude()
            )
        );

        $email = (new Email())
            ->from('support@weather-api.com')
            ->to($entity->getUserId()->getEmail())
            ->subject('Weather notification for ' . $entity->getLocalizationName())
            ->text((string) $weatherData);

        $this->mailer->send($email);
    }
}
