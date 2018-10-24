<?php

namespace App\Repository\SponsorshipLevelBenefit;

use App\Entity\SponsorshipLevelBenefit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SponsorshipLevelBenefit|null find($id, $lockMode = null, $lockVersion = null)
 * @method SponsorshipLevelBenefit|null findOneBy(array $criteria, array $orderBy = null)
 * @method SponsorshipLevelBenefit[]    findAll()
 * @method SponsorshipLevelBenefit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SponsorshipLevelBenefitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SponsorshipLevelBenefit::class);
    }
}
