<?php

namespace App\Repository;

use App\Client\Weather\OpenWeatherMap\Client;
use App\Entity\NotificationDefinition;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @extends ServiceEntityRepository<NotificationDefinition>
 *
 * @method NotificationDefinition|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationDefinition|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationDefinition[]    findAll()
 * @method NotificationDefinition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationDefinitionRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private Client $client,
    ) {
        parent::__construct($registry, NotificationDefinition::class);
    }

    public function save(NotificationDefinition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NotificationDefinition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function create(User $user, array $coordinates): NotificationDefinition
    {
        $localizationName = $this->client->fetchLocalizationName($coordinates);

        $notificationDefinition = new NotificationDefinition();
        $token = bin2hex(random_bytes(20));
        $notificationDefinition->setConfirmationToken($token);
        $notificationDefinition->setUserId($user);
        $notificationDefinition->setLatitude($coordinates['latitude']);
        $notificationDefinition->setLongitude($coordinates['longitude']);
        $notificationDefinition->setLocalizationName($localizationName);
        $notificationDefinition->setIsConfirmed(false);

        $this->save($notificationDefinition, true);

        return $notificationDefinition;
    }

    public function findByUserAndCoordinates(User $user, array $coordinates): ?NotificationDefinition
    {
        return $this->findOneBy([
            'userId' => $user->getId(),
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude']
        ]);
    }

    public function getByUserAndCoordinates(User $user, array $coordinates): NotificationDefinition
    {
        $notificationDefinition = $this->findByUserAndCoordinates($user, $coordinates);

        if (!$notificationDefinition) {
            $notificationDefinition = $this->create($user, $coordinates);
        } else {
            throw new BadRequestHttpException('Notification definition already exists');
        }

        return $notificationDefinition;
    }

    public function findIsConfirmed(): array
    {
        return $this->findBy(['isConfirmed' => true]);
    }

    public function findOneByConfirmationToken(string $token): ?NotificationDefinition
    {
        return $this->findOneBy(['confirmationToken' => $token]);
    }
}
