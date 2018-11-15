<?php

declare(strict_types=1);

namespace App\Repository\SpecialBenefit;

use App\Entity\SpecialBenefit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SpecialBenefitRepository extends ServiceEntityRepository implements SpecialBenefitRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SpecialBenefit::class);
    }

    /**
     * @param mixed    $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     * @return SpecialBenefit|null
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?SpecialBenefit
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    /**
     * @return UuidInterface
     * @throws \Exception
     */
    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    /**
     * @param SpecialBenefit $specialBenefit
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(SpecialBenefit $specialBenefit): void
    {
        $this->getEntityManager()->persist($specialBenefit);
        $this->getEntityManager()->flush();
    }

    /**
     * @param SpecialBenefit $specialBenefit
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(SpecialBenefit $specialBenefit): void
    {
        $this->getEntityManager()->remove($specialBenefit);
        $this->getEntityManager()->flush();
    }
}
