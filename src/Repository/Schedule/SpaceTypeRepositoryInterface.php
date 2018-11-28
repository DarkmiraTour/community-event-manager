<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Entity\SpaceType;
use Ramsey\Uuid\UuidInterface;

interface SpaceTypeRepositoryInterface
{
    public function find(string $id): ?SpaceType;

    /**
     * @return SpaceType[]
     */
    public function findAll(): array;

    public function nextIdentity(): UuidInterface;

    public function save(SpaceType $spaceType): void;

    public function remove(SpaceType $spaceType): void;
}
