<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipBenefit;

use App\Entity\SponsorshipBenefit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SponsorshipBenefit|null find($id, $lockMode = null, $lockVersion = null)
 * @method SponsorshipBenefit|null findOneBy(array $criteria, array $orderBy = null)
 * @method SponsorshipBenefit[]    findAll()
 * @method SponsorshipBenefit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SponsorshipBenefitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SponsorshipBenefit::class);
    }

    /**
     * @return int|null
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMaxPosition()
    {
        return $this->createQueryBuilder('sb')
            ->select('MAX(sb.position)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
