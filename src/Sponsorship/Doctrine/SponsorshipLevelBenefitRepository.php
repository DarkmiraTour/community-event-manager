<?php

declare(strict_types=1);

namespace App\Sponsorship\Doctrine;

use App\Sponsorship\SponsorshipBenefit;
use App\Sponsorship\SponsorshipLevel;
use App\Sponsorship\SponsorshipLevelBenefit;
use App\Sponsorship\SponsorshipLevelBenefit\SponsorshipLevelBenefitRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SponsorshipLevelBenefitRepository extends ServiceEntityRepository implements SponsorshipLevelBenefitRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
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
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    private function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
