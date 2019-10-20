<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipBenefit;

use App\Sponsorship\SponsorshipBenefit;

interface SponsorshipBenefitManagerInterface
{
    public function find(string $id): SponsorshipBenefit;

    public function findAll(): array;

    public function createFrom(SponsorshipBenefitRequest $sponsorshipBenefitRequest): SponsorshipBenefit;

    public function createWith(string $label, ?int $position): SponsorshipBenefit;

    public function save(SponsorshipBenefit $sponsorshipBenefit): void;

    public function remove(SponsorshipBenefit $sponsorshipBenefit): void;

    public function switchPosition(string $move, string $id): SponsorshipBenefit;

    public function getMaxPosition(): ?int;

    /**
     * @return SponsorshipBenefit[]
     */
    public function getOrderedList(): array;
}
