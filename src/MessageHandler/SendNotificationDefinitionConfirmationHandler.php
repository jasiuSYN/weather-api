<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SendNotificationDefinitionConfirmation;
use App\Repository\NotificationDefinitionRepository;
use App\Service\EmailConfirmationToken;

class SendNotificationDefinitionConfirmationHandler
{
    public function __construct(
        private NotificationDefinitionRepository $definitionRepository,
        private EmailConfirmationToken $emailConfirmationToken
    ) {
    }

    public function __invoke(SendNotificationDefinitionConfirmation $definitionConfirmation): void
    {
        $notificationDefinition = $this->definitionRepository->getByUserAndCoordinates(
            $definitionConfirmation->getUserId(),
            $definitionConfirmation->getCoordinates()
        );

        $this->emailConfirmationToken->sendConfirmation($notificationDefinition);
    }
}
