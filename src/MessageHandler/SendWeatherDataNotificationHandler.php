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
        private NotificationRepository $notificationRepository,
        private WeatherNotificationSender $weatherNotificationSender
    ) {
    }

    public function __invoke(SendWeatherDataNotification $definitionConfirmation)
    {
        $notification = $this->notificationRepository->find(($definitionConfirmation->getNotificationId()));

        try {
            $this->weatherNotificationSender->send($notification->getDefinitionId());
            $this->setStatus($notification, Notification::STATUS_SUCCESS);
        } catch (\Exception $e) {
            $this->setStatus($notification, Notification::STATUS_FAILED);
        }
    }

    public function setStatus(Notification $notification, string $status): void
    {
        $notification->setStatus($status);
        $this->notificationRepository->save($notification, true);
    }
}
