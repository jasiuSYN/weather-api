<?php

declare(strict_types=1);

namespace App\Email;

use App\Entity\NotificationDefinition;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SendWeatherNotification
{
    public function __construct(
        private MailerInterface $mailer,
        private HttpClientInterface $client,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function send(NotificationDefinition $entity): void
    {
        $weatherData = $this->fetchWeatherForCoordinates($entity);

        $email = (new Email())
            ->from('support@weather-api.com')
            ->to($entity->getUserId()->getEmail())
            ->subject('Weather notification for ' . $entity->getLocalizationName())
            ->text($weatherData);

        $this->mailer->send($email);
    }

    public function fetchWeatherForCoordinates(NotificationDefinition $entity): string
    {
        $url = $this->urlGenerator->generate(
            'weather-coordinates',
            [
                'latitude' => $entity->getLatitude(),
                'longitude' => $entity->getLongitude()
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $response = $this->client->request(
            method: 'GET',
            url: $url,
        );

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Failed to fetch weather data');
        }

        return $response->getContent();
    }
}