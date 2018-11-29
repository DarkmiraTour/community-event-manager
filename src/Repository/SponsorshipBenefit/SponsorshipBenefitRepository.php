<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipBenefit;

use App\Entity\SponsorshipBenefit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class SponsorshipBenefitRepository extends ServiceEntityRepository implements SponsorshipBenefitRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SponsorshipBenefit::class);
    }

    public function getMaxPosition(): ?int
    {
        return $this->createQueryBuilder('sb')
            ->select('MAX(sb.position)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function createSponsorshipBenefit(string $label, ?int $position): SponsorshipBenefit
    {
        return new SponsorshipBenefit(
            $this->nextIdentity(),
            $label,
            $position
        );
    }

    public function save(SponsorshipBenefit $sponsorshipBenefit): void
    {
        $this->getEntityManager()->persist($sponsorshipBenefit);
        $this->getEntityManager()->flush();
    }

    public function remove(SponsorshipBenefit $sponsorshipBenefit): void
    {
        $this->getEntityManager()->remove($sponsorshipBenefit);
        $this->getEntityManager()->flush();
    }

    public function find($id, $lockMode = null, $lockVersion = null): ?SponsorshipBenefit
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?SponsorshipBenefit
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
