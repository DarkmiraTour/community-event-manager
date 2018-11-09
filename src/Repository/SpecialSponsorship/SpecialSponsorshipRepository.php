<?php

declare(strict_types=1);

namespace App\Repository\SpecialSponsorship;

use App\Entity\SpecialSponsorship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SpecialSponsorship|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialSponsorship|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialSponsorship[]    findAll()
 * @method SpecialSponsorship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialSponsorshipRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SpecialSponsorship::class);
    }
}
