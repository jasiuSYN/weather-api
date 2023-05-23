<?php

declare(strict_types=1);

namespace App\Command;

use App\EmailService\WeatherNotificationSender;
use App\Entity\Notification;
use App\Message\SendWeatherDataNotification;
use App\Repository\NotificationDefinitionRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'app:send-weather-notification-email')]
class SendWeatherNotificationEmailCommand extends Command
{
    public function __construct(
        private NotificationRepository $notificationRepository,
        private NotificationDefinitionRepository $definitionRepository,
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $confirmedNotificationDefinitions = $this->definitionRepository->findAllConfirmed();

        if (empty($confirmedNotificationDefinitions)) {
            $output->writeln('No confirmed notification definitions found.');
            return Command::SUCCESS;
        }

        foreach ($confirmedNotificationDefinitions as $confirmedNotificationDefinition) {
            $notification = Notification::fromDefinition($confirmedNotificationDefinition);
            $this->notificationRepository->save($notification, true);

            if ($notification->isStatus() === Notification::STATUS_CREATED) {
                $message = new SendWeatherDataNotification($notification->getId());
                $this->messageBus->dispatch($message);
            }
        }
        return Command::SUCCESS;
    }
}
