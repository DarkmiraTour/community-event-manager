<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipLevelBenefit;

use App\Entity\SponsorshipLevel;
use App\Entity\SponsorshipBenefit;
use App\Entity\SponsorshipLevelBenefit;
use App\Dto\SponsorshipLevelBenefitRequest;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SponsorshipLevelBenefitManager implements SponsorshipLevelBenefitManagerInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SponsorshipLevelBenefit::class);
    }

    public function find(string $id): ?SponsorshipLevelBenefit
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param SponsorshipLevelBenefitRequest $sponsorshipLevelBenefitRequest
     *
     * @return SponsorshipLevelBenefit
     *
     * @throws \Exception
     */
    public function createFrom(SponsorshipLevelBenefitRequest $sponsorshipLevelBenefitRequest): SponsorshipLevelBenefit
    {
        return new SponsorshipLevelBenefit(
            $this->nextIdentity(),
            $sponsorshipLevelBenefitRequest->sponsorshipLevel,
            $sponsorshipLevelBenefitRequest->sponsorshipBenefit,
            $sponsorshipLevelBenefitRequest->content
        );
    }

    /**
     * @return UuidInterface
     *
     * @throws \Exception
     */
    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(SponsorshipLevelBenefit $sponsorshipBenefit): void
    {
        $this->entityManager->persist($sponsorshipBenefit);
        $this->entityManager->flush();
    }

    public function remove(SponsorshipLevelBenefit $sponsorshipBenefit): void
    {
        $this->entityManager->remove($sponsorshipBenefit);
        $this->entityManager->flush();
    }

    public function getByBenefitAndLevel(SponsorshipBenefit $sponsorshipBenefit, SponsorshipLevel $sponsorshipLevel): ?SponsorshipLevelBenefit
    {
        return $this->repository->findOneBy(['sponsorshipBenefit' => $sponsorshipBenefit, 'sponsorshipLevel' => $sponsorshipLevel]);
    }
}
