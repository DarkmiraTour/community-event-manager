<?php

namespace App\Repository\SponsorshipLevel;

use App\Entity\SponsorshipLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SponsorshipLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method SponsorshipLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method SponsorshipLevel[]    findAll()
 * @method SponsorshipLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SponsorshipLevelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SponsorshipLevel::class);
    }

    /**
     * @return int|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMaxPosition()
    {
        return $this->createQueryBuilder('sl')
            ->select('MAX(sl.position)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
