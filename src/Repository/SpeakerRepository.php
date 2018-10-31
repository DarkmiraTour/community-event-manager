<?php declare(strict_types=1);

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

    public function save(Speaker $speaker): void
    {
        $this->getEntityManager()->persist($speaker);
        $this->getEntityManager()->flush();
    }

    public function remove(Speaker $speaker): void
    {
        $this->getEntityManager()->remove($speaker);
        $this->getEntityManager()->flush();
    }
}
