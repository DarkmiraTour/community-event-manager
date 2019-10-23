<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipLevelBenefit;

use App\Dto\SponsorshipLevelBenefitRequest;
use App\Entity\SponsorshipBenefit;
use App\Entity\SponsorshipLevel;
use App\Entity\SponsorshipLevelBenefit;

interface SponsorshipLevelBenefitManagerInterface
{
    public function find(string $id): SponsorshipLevelBenefit;

    public function findAll(): array;

    public function createFrom(SponsorshipLevelBenefitRequest $sponsorshipLevelBenefitRequest): SponsorshipLevelBenefit;

    public function createWith(SponsorshipLevel $sponsorshipLevel, SponsorshipBenefit $sponsorshipBenefit, ?string $content): SponsorshipLevelBenefit;

    public function save(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void;

    public function remove(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void;

    public function getByBenefitAndLevel(SponsorshipBenefit $sponsorshipBenefit, SponsorshipLevel $sponsorshipLevel): ?SponsorshipLevelBenefit;
}
