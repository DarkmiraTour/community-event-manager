<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipLevel;

use App\Entity\SponsorshipLevel;

interface SponsorshipLevelRepositoryInterface
{
    public function getMaxPosition(): ?int;

    public function createSponsorshipLevel(string $label, float $price, ?int $position): SponsorshipLevel;

    public function save(SponsorshipLevel $sponsorshipLevel): void;

    public function remove(SponsorshipLevel $sponsorshipLevel): void;

    /**
     * @param mixed    $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     *
     * @return SponsorshipLevel|null
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?SponsorshipLevel;

    public function findAll(): array;

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return SponsorshipLevel|null
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?SponsorshipLevel;
}
