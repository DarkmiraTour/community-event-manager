<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipLevel;

use App\Entity\SponsorshipLevel;
use App\Dto\SponsorshipLevelRequest;

interface SponsorshipLevelManagerInterface
{
    public function find(string $id): SponsorshipLevel;

    public function findAll(): array;

    public function createFrom(SponsorshipLevelRequest $sponsorshipLevelRequest): SponsorshipLevel;

    public function createWith(string $label, float $price, ?int $position): SponsorshipLevel;

    public function save(SponsorshipLevel $sponsorshipLevel): void;

    public function remove(SponsorshipLevel $sponsorshipLevel): void;

    public function getOrderedList(): array;

    public function switchPosition(string $move, string $id): SponsorshipLevel;

    public function getMaxPosition(): ?int;
}
