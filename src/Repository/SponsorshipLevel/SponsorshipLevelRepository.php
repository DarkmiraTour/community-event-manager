<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipLevel;

use App\Entity\SponsorshipLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class SponsorshipLevelRepository extends ServiceEntityRepository implements SponsorshipLevelRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SponsorshipLevel::class);
    }

    public function getMaxPosition(): ?int
    {
        return $this->createQueryBuilder('sl')
            ->select('MAX(sl.position)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function createSponsorshipLevel(string $label, float $price, ?int $position): SponsorshipLevel
    {
        return new SponsorshipLevel(
            $this->nextIdentity(),
            $label,
            $price,
            $position
        );
    }

    public function save(SponsorshipLevel $sponsorshipLevel): void
    {
        $this->getEntityManager()->persist($sponsorshipLevel);
        $this->getEntityManager()->flush();
    }

    public function remove(SponsorshipLevel $sponsorshipLevel): void
    {
        $this->getEntityManager()->remove($sponsorshipLevel);
        $this->getEntityManager()->flush();
    }

    public function find($id, $lockMode = null, $lockVersion = null): ?SponsorshipLevel
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findAllWithBenefits(): array
    {
        return $this->createQueryBuilder('level')
            ->select('level, levelBenefit, benefit')
            ->leftJoin('level.sponsorshipLevelBenefits', 'levelBenefit')
            ->leftJoin('levelBenefit.sponsorshipBenefit', 'benefit')
            ->orderBy('level.position')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?SponsorshipLevel
    {
        return parent::findOneBy($criteria, $orderBy);
    }

    /**
     * @return UuidInterface
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    private function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
