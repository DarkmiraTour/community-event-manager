<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipBenefit;

use App\Entity\SponsorshipBenefit;
use App\Dto\SponsorshipBenefitRequest;

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

    public function getOrderedList(): array;
}
