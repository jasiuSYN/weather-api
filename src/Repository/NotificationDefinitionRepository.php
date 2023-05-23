<?php

namespace App\Repository;

use App\Entity\NotificationDefinition;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function findByUserCoordinatesLocalizationName(
        User $user,
        string $latitude,
        string $longitude,
        string $localization
    ): ?NotificationDefinition {
        return $this->findOneBy([
            'userId' => $user->getId(),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'localizationName' => $localization
        ]);
    }
    public function findAllConfirmed(): array
    {
        return $this->findBy(['isConfirmed' => true]);
    }

    public function findOneByConfirmationToken(string $token): ?NotificationDefinition
    {
        return $this->findOneBy(['confirmationToken' => $token]);
    }
}
