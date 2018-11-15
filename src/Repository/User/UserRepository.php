<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function find($id, $lockMode = null, $lockVersion = null): ?User
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?User
    {
        return parent::findOneBy($criteria, $orderBy);
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
