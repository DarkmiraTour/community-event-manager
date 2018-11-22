<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipBenefit;

use App\Entity\SponsorshipBenefit;
use App\Dto\SponsorshipBenefitRequest;
use Ramsey\Uuid\UuidInterface;

interface SponsorshipBenefitManagerInterface
{
    public function find(string $id): ?SponsorshipBenefit;

    /**
     * @return SponsorshipBenefit[]
     */
    public function findAll();

    public function createFrom(SponsorshipBenefitRequest $sponsorshipBenefitRequest): SponsorshipBenefit;

    public function nextIdentity(): UuidInterface;

    public function save(SponsorshipBenefit $sponsorshipBenefit): void;

    public function remove(SponsorshipBenefit $sponsorshipBenefit): void;

    public function switchPosition(string $move, string $id): SponsorshipBenefit;

    public function getMaxPosition(): ?int;

    /**
     * @return SponsorshipBenefit[]
     */
    public function getOrderedList();
}
