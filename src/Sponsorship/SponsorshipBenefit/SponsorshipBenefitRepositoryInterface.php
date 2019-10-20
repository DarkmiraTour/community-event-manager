<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipBenefit;

use App\Sponsorship\SponsorshipBenefit;

interface SponsorshipBenefitRepositoryInterface
{
    public function getMaxPosition(): ?int;

    public function createSponsorshipBenefit(string $label, ?int $position): SponsorshipBenefit;

    public function save(SponsorshipBenefit $sponsorshipBenefit): void;

    public function remove(SponsorshipBenefit $sponsorshipBenefit): void;

    /**
     * @param int|null $lockMode
     * @param int|null $lockVersion
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?SponsorshipBenefit;

    public function findAll(): array;

    /**
     * @param int|null $limit
     * @param int|null $offset
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    public function findOneBy(array $criteria, array $orderBy = null): ?SponsorshipBenefit;
}
