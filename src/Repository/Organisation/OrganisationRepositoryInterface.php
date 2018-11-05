<?php

declare(strict_types=1);

namespace App\Repository\Organisation;

use App\Entity\Organisation;
use Ramsey\Uuid\UuidInterface;

interface OrganisationRepositoryInterface
{
    public function find(string $id): ?Organisation;

    /**
     * @return Organisation[]
     */
    public function findAll();

    public function nextIdentity(): UuidInterface;

    public function save(Organisation $organisation): void;

    public function remove(Organisation $organisation): void;
}
