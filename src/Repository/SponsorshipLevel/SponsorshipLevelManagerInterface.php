<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipLevel;

use App\Entity\SponsorshipLevel;
use App\Dto\SponsorshipLevelRequest;
use Ramsey\Uuid\UuidInterface;

interface SponsorshipLevelManagerInterface
{
    public function find(string $id): ?SponsorshipLevel;
    /**
     * @return SponsorshipLevel[]
     */
    public function findAll();

    public function createFrom(SponsorshipLevelRequest $sponsorshipLevelRequest): SponsorshipLevel;

    public function nextIdentity(): UuidInterface;

    public function save(SponsorshipLevel $sponsorshipLevel): void;

    public function remove(SponsorshipLevel $sponsorshipLevel): void;

    /**
     * @return SponsorshipLevel[]
     */
    public function getOrderedList();

    public function switchPosition(string $move, string $id): SponsorshipLevel;

    public function getMaxPosition(): ?int;
}
