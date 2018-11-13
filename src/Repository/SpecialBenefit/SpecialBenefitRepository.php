<?php

declare(strict_types=1);

namespace App\Repository\SpecialBenefit;

use App\Entity\SpecialBenefit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SpecialBenefit|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialBenefit|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialBenefit[]    findAll()
 * @method SpecialBenefit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialBenefitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SpecialBenefit::class);
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
