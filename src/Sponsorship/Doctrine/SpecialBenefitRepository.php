<?php

declare(strict_types=1);

namespace App\Sponsorship\Doctrine;

use App\Sponsorship\SpecialBenefit;
use App\Sponsorship\SpecialBenefit\SpecialBenefitRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SpecialBenefitRepository extends ServiceEntityRepository implements SpecialBenefitRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialBenefit::class);
    }

    public function createSpecialBenefit(string $label, float $price, string $description): SpecialBenefit
    {
        return new SpecialBenefit(
            $this->nextIdentity(),
            $label,
            $price,
            $description
        );
    }

    public function find($id, $lockMode = null, $lockVersion = null): ?SpecialBenefit
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function save(SpecialBenefit $specialBenefit): void
    {
        $this->getEntityManager()->persist($specialBenefit);
        $this->getEntityManager()->flush();
    }

    public function remove(SpecialBenefit $specialBenefit): void
    {
        $this->getEntityManager()->remove($specialBenefit);
        $this->getEntityManager()->flush();
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
