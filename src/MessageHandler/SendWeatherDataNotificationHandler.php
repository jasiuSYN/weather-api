<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\EmailService\WeatherNotificationSender;
use App\Entity\Notification;
use App\Message\SendNotificationDefinitionConfirmation;
use App\Message\SendWeatherDataNotification;
use App\Repository\NotificationDefinitionRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendWeatherDataNotificationHandler
{
    public function __construct(
        private NotificationDefinitionRepository $definitionRepository,
        private NotificationRepository $notificationRepository,
        private WeatherNotificationSender   $weatherNotificationSender
    ) {
    }

    public function __invoke(SendWeatherDataNotification $definitionConfirmation)
    {
        $notificationDefinition = $this->definitionRepository->find($definitionConfirmation->getDefinitionId());
        $notifications = $notificationDefinition->getNotifications();

        try {
            $this->weatherNotificationSender->send($notificationDefinition);

            foreach ($notifications as $notification) {
                $notification->setStatus(Notification::STATUS_SUCCESS);
                $this->notificationRepository->save($notification, true);
            }
        } catch (\Exception $e) {
            foreach ($notifications as $notification) {
                $notification->setStatus(Notification::STATUS_FAILED);
                $this->notificationRepository->save($notification, true);
            }
        }
    }
}
