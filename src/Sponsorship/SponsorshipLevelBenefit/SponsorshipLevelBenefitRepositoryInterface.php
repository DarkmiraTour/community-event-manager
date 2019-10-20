<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevelBenefit;

use App\Sponsorship\SponsorshipBenefit;
use App\Sponsorship\SponsorshipLevel;
use App\Sponsorship\SponsorshipLevelBenefit;

interface SponsorshipLevelBenefitRepositoryInterface
{
    public function createSponsorshipLevelBenefit(SponsorshipLevel $sponsorshipLevel, SponsorshipBenefit $sponsorshipBenefit, ?string $content): SponsorshipLevelBenefit;

    public function save(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void;

    public function remove(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void;

    /**
     * @param mixed    $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     *
     * @return SponsorshipLevelBenefit|null
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?SponsorshipLevelBenefit;

    public function findAll(): array;

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return SponsorshipLevelBenefit|null
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?SponsorshipLevelBenefit;
}
