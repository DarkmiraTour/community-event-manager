<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipLevelBenefit;

use App\Entity\SponsorshipBenefit;
use App\Entity\SponsorshipLevel;
use App\Entity\SponsorshipLevelBenefit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class SponsorshipLevelBenefitRepository extends ServiceEntityRepository implements SponsorshipLevelBenefitRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SponsorshipLevelBenefit::class);
    }

    public function createSponsorshipLevelBenefit(SponsorshipLevel $sponsorshipLevel, SponsorshipBenefit $sponsorshipBenefit, ?string $content): SponsorshipLevelBenefit
    {
        return new SponsorshipLevelBenefit(
            $this->nextIdentity(),
            $sponsorshipLevel,
            $sponsorshipBenefit,
            $content
        );
    }

    public function save(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void
    {
        $this->getEntityManager()->persist($sponsorshipLevelBenefit);
        $this->getEntityManager()->flush();
    }

    public function remove(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void
    {
        $this->getEntityManager()->remove($sponsorshipLevelBenefit);
        $this->getEntityManager()->flush();
    }

    public function find($id, $lockMode = null, $lockVersion = null): ?SponsorshipLevelBenefit
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?SponsorshipLevelBenefit
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
