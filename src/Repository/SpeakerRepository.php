<?php

namespace App\Repository;

use App\Entity\Speaker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Speaker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Speaker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Speaker[]    findAll()
 * @method Speaker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpeakerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Speaker::class);
    }

    public function save(Speaker $speaker)
    {
        $this->getEntityManager()->persist($speaker);
        $this->getEntityManager()->flush();
    }

    public function remove(Speaker $speaker)
    {
        $this->getEntityManager()->remove($speaker);
        $this->getEntityManager()->flush();
    }
}
