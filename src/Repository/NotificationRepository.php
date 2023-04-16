<?php

namespace App\Repository;

use App\Client\Weather\OpenWeatherMap\Client;
use App\Email\SendWeatherNotification;
use App\Entity\Notification;
use App\Entity\NotificationDefinition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 *
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private SendWeatherNotification $sendWeatherNotification
    ) {
        parent::__construct($registry, Notification::class);
    }

    public function save(Notification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Notification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function create(NotificationDefinition $notificationDefinition): Notification
    {
        $notificationEntity = $this->findNotificationById($notificationDefinition);

        if (isset($notificationEntity)) {
            return $notificationEntity;
        } else {
            $notification = new Notification();
            $notification->setDefinitionId($notificationDefinition->getId());
            $notification->setSentAt(new \DateTime());
            $notification->setStatus($notification::STATUS_CREATED);

            $this->getEntityManager()->persist($notification);

            return $notification;
        }
    }

    public function findNotificationById(NotificationDefinition $notificationDefinition): ?Notification
    {
        // TODO bład w tej części, funkcja getNotification jest PersistentCollection. Trzeba aby zwróciło ewentualnie
        // TODO powiazane notyfikacje. Na ten moment jest zwracana lista/kolecja przez One2Many
        return $this->find($notificationDefinition->getNotifications());
    }

    public function fromDefinition(array $definitions): void
    {
        foreach ($definitions as $definition) {
            $this->sendWeatherNotification->send($definition);

            $this->create($definition);
        }

        $this->getEntityManager()->flush();
    }
}
