<?php
declare(strict_types=1);

namespace App\Repository\Space;

use App\Dto\SpaceRequest;
use App\Entity\Space;
use Ramsey\Uuid\UuidInterface;

interface SpaceRepositoryInterface
{
    public function find(string $id): ?Space;

    /**
     * @return Space[]
     */
    public function findAll();

    public function createFrom(SpaceRequest $spaceRequest): Space;

    public function nextIdentity(): UuidInterface;

    public function save(Space $space): void;

    public function remove(Space $space): void;
}