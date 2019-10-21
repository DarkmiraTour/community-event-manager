<?php

declare(strict_types=1);

namespace App\Organisation;

use Ramsey\Uuid\UuidInterface;

interface OrganisationRepositoryInterface
{
    public function find(string $id): ?Organisation;

    /**
     * @return Organisation[]
     */
    public function findAll();

    public function createFrom(OrganisationRequest $organisationRequest): Organisation;

    public function nextIdentity(): UuidInterface;

    public function save(Organisation $organisation): void;

    public function remove(Organisation $organisation): void;
}
