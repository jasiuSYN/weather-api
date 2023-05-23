<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SendNotificationDefinitionConfirmation;
use App\Repository\NotificationDefinitionRepository;
use App\EmailService\NotificationConfirmationSender;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendNotificationDefinitionConfirmationHandler
{
    public function __construct(
        private NotificationDefinitionRepository $definitionRepository,
        private NotificationConfirmationSender   $notificationConfirmationSender,
    ) {
    }

    public function __invoke(SendNotificationDefinitionConfirmation $definitionConfirmation)
    {
        $notificationDefinition = $this->definitionRepository->find($definitionConfirmation->getDefinitionId());

        $this->notificationConfirmationSender->sendConfirmation($notificationDefinition);
    }
}
