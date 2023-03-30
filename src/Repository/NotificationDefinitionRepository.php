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
    public function __construct(ManagerRegistry $registry)
    {
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
        $notificationDefinition = new NotificationDefinition();
        $token = bin2hex(random_bytes(20));
        $notificationDefinition->setConfirmationToken($token);
        $notificationDefinition->setUserId($user);
        $notificationDefinition->setCoordinates($coordinates);
        $notificationDefinition->setIsConfirmed(false);

        $this->getEntityManager()->persist($notificationDefinition);
        $this->getEntityManager()->flush();

        return $notificationDefinition;
    }

//    /**
//     * @return NotificationDefinition[] Returns an array of NotificationDefinition objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NotificationDefinition
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
