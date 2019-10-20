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
     * @param mixed    $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     *
     * @return SponsorshipBenefit|null
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?SponsorshipBenefit;

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
     * @return SponsorshipBenefit|null
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?SponsorshipBenefit;
}
