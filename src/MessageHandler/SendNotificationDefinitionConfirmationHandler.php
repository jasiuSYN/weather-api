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
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(SendNotificationDefinitionConfirmation $definitionConfirmation)
    {
        $user = $this->userRepository->find($definitionConfirmation->getUserId());

        $notificationDefinition = $this->definitionRepository->getByUserAndCoordinates(
            $user,
            $definitionConfirmation->getCoordinates()
        );

        $this->emailConfirmationToken->sendConfirmation($notificationDefinition);
    }
}
