<?php

declare(strict_types=1);

namespace App\Repository\Organisation;

use App\Entity\Organisation;

interface OrganisationRepositoryInterface
{
    public function find(string $id): ?Organisation;

    /**
     * @return Organisation[]
     */
    public function findAll();

    public function save(Organisation $organisation): void;

    public function remove(Organisation $organisation): void;
}
