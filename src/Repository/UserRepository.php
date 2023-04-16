<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function create(string $email): User
    {
        $newUser = new User();
        $newUser->setEmail($email);
        $token = bin2hex(random_bytes(20));
        $newUser->setAuthToken($token);

        $this->getEntityManager()->persist($newUser);
        $this->getEntityManager()->flush();

        return $newUser;
    }

    public function findByEmail(string $email): ?User
    {
        $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user) {
            return $user;
        } else {
            return null;
        }
    }

    public function getByEmail(string $email): User
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            $user = $this->create($email);
        }

        return $user;
    }
}
