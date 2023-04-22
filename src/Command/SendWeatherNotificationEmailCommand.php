<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Notification;
use App\Repository\NotificationDefinitionRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:send-weather-notification-email')]
class SendWeatherNotificationEmailCommand extends Command
{
    public function __construct(
        private NotificationRepository $notificationRepository,
        private NotificationDefinitionRepository $definitionRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $confirmedNotificationDefinitions = $this->definitionRepository->findIsConfirmed();

        if (!$confirmedNotificationDefinitions) {
            return Command::FAILURE;
        }

        foreach ($confirmedNotificationDefinitions as $confirmedNotificationDefinition) {
            $notification = Notification::fromDefinition($confirmedNotificationDefinition);
            $this->notificationRepository->save($notification, true);

            if ($notification->isStatus() === Notification::STATUS_CREATED) {
                // TODO wysyłka powiadomienia -> zmiana statusu na STATUS_SUCCESS
            }
        }
        return Command::SUCCESS;
    }
}
