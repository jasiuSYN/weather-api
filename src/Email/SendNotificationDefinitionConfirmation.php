<?php

declare(strict_types=1);

namespace App\Email;

use App\Entity\NotificationDefinition;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SendNotificationDefinitionConfirmation
{
    public function __construct(private MailerInterface $mailer, private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function sendConfirmation(NotificationDefinition $notificationDefinition): void
    {
        $confirmationLink = $this->urlGenerator->generate(
            'token-confirmation',
            ['token' => $notificationDefinition->getConfirmationToken()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $email = (new Email())
            ->from('support@weather-api.com')
            ->to($notificationDefinition->getUserId()->getEmail())
            ->subject('Notification confirmation')
            ->text($confirmationLink);

        $this->mailer->send($email);
    }
}
