<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipLevelBenefit;

use App\Entity\SponsorshipLevel;
use App\Entity\SponsorshipBenefit;
use App\Entity\SponsorshipLevelBenefit;
use App\Dto\SponsorshipLevelBenefitRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class SponsorshipLevelBenefitManager implements SponsorshipLevelBenefitManagerInterface
{
    private $repository;

    public function __construct(SponsorshipLevelBenefitRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $id): SponsorshipLevelBenefit
    {
        return $this->checkEntity($this->repository->find($id));
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function createFrom(SponsorshipLevelBenefitRequest $sponsorshipLevelBenefitRequest): SponsorshipLevelBenefit
    {
        return $this->repository->createSponsorshipLevelBenefit($sponsorshipLevelBenefitRequest->sponsorshipLevel, $sponsorshipLevelBenefitRequest->sponsorshipBenefit, $sponsorshipLevelBenefitRequest->content);
    }

    public function createWith(SponsorshipLevel $sponsorshipLevel, SponsorshipBenefit $sponsorshipBenefit, ?string $content): SponsorshipLevelBenefit
    {
        return $this->repository->createSponsorshipLevelBenefit($sponsorshipLevel, $sponsorshipBenefit, $content);
    }

    public function save(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void
    {
        $this->repository->save($sponsorshipLevelBenefit);
    }

    public function remove(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void
    {
        $this->repository->remove($sponsorshipLevelBenefit);
    }

    public function getByBenefitAndLevel(SponsorshipBenefit $sponsorshipBenefit, SponsorshipLevel $sponsorshipLevel): ?SponsorshipLevelBenefit
    {
        return $this->repository->findOneBy(['sponsorshipBenefit' => $sponsorshipBenefit, 'sponsorshipLevel' => $sponsorshipLevel]);
    }

    private function checkEntity(?SponsorshipLevelBenefit $sponsorshipLevelBenefit): SponsorshipLevelBenefit
    {
        if (!$sponsorshipLevelBenefit) {
            throw new NotFoundHttpException();
        }

        return $sponsorshipLevelBenefit;
    }
}
