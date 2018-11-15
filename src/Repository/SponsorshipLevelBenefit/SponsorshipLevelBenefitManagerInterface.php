<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipLevelBenefit;

use App\Entity\SponsorshipLevel;
use App\Entity\SponsorshipBenefit;
use App\Entity\SponsorshipLevelBenefit;
use App\Dto\SponsorshipLevelBenefitRequest;
use Ramsey\Uuid\UuidInterface;

interface SponsorshipLevelBenefitManagerInterface
{
    public function find(string $id): ?SponsorshipLevelBenefit;

    /**
     * @return SponsorshipLevelBenefit[]
     */
    public function findAll();

    public function createFrom(SponsorshipLevelBenefitRequest $sponsorshipLevelBenefitRequest): SponsorshipLevelBenefit;

    public function nextIdentity(): UuidInterface;

    public function save(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void;

    public function remove(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void;

    public function getByBenefitAndLevel(SponsorshipBenefit $sponsorshipBenefit, SponsorshipLevel $sponsorshipLevel): ?SponsorshipLevelBenefit;
}
