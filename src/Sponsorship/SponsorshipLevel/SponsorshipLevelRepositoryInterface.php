<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevel;

use App\Sponsorship\SponsorshipLevel;

interface SponsorshipLevelRepositoryInterface
{
    public function getMaxPosition(): ?int;

    public function createSponsorshipLevel(string $label, float $price, ?int $position): SponsorshipLevel;

    public function save(SponsorshipLevel $sponsorshipLevel): void;

    public function remove(SponsorshipLevel $sponsorshipLevel): void;

    /**
     * @param int|null $lockMode
     * @param int|null $lockVersion
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?SponsorshipLevel;

    public function findAll(): array;

    /**
     * @param int|null $limit
     * @param int|null $offset
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    public function findOneBy(array $criteria, array $orderBy = null): ?SponsorshipLevel;
}
