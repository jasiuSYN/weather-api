<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SendNotificationDefinitionConfirmation;
use App\Repository\NotificationDefinitionRepository;
use App\Repository\UserRepository;
use App\Service\EmailConfirmationToken;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendNotificationDefinitionConfirmationHandler
{
    public function __construct(
        private NotificationDefinitionRepository $definitionRepository,
        private EmailConfirmationToken $emailConfirmationToken,
    ) {
    }

    public function __invoke(SendNotificationDefinitionConfirmation $definitionConfirmation)
    {
        $notificationDefinition = $this->definitionRepository->find($definitionConfirmation->getDefinitionId());

        $this->emailConfirmationToken->sendConfirmation($notificationDefinition);
    }
}
