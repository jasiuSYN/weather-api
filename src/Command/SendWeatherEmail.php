<?php

declare(strict_types=1);

namespace App\Command;

use App\Email\SendWeatherNotification;
use App\Entity\Notification;
use App\Entity\NotificationDefinition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:send-email')]
class SendWeatherEmail extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SendWeatherNotification $sendWeatherNotification,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entities = $this->entityManager->getRepository(NotificationDefinition::class)->findIsConfirmed();
        $notificationRepository = $this->entityManager->getRepository(Notification::class);

        foreach ($entities as $entity) {
            $this->sendWeatherNotification->send($entity);

            $notificationRepository->create($entity);

            $this->entityManager->persist($notificationRepository);
        }
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
