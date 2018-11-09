<?php

declare(strict_types=1);

namespace App\Repository\SpecialSponsorship;

use App\Entity\SpecialSponsorship;
use App\Dto\SpecialSponsorshipRequest;
use Ramsey\Uuid\UuidInterface;

interface SpecialSponsorshipManagerInterface
{
    public function find(string $id): ?SpecialSponsorship;
    /**
     * @return SpecialSponsorship[]
     */
    public function findAll();

    public function createFrom(SpecialSponsorshipRequest $specialSponsorshipRequest): SpecialSponsorship;

    public function nextIdentity(): UuidInterface;

    public function save(SpecialSponsorship $specialSponsorship): void;

    public function remove(SpecialSponsorship $specialSponsorship): void;
}
