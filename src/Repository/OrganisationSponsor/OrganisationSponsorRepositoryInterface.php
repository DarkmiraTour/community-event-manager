<?php

declare(strict_types=1);

namespace App\Repository\OrganisationSponsor;

use App\Dto\OrganisationSponsorRequest;
use App\Entity\OrganisationSponsor;
use Ramsey\Uuid\UuidInterface;

interface OrganisationSponsorRepositoryInterface
{
    public function find(string $id): ?OrganisationSponsor;

    /**
     * @return OrganisationSponsor[]
     */
    public function findAll();

    public function findBy(array $criteria = [], array $orderBy = [], int $limit = null, int $offset = null): array;

    public function createFrom(OrganisationSponsorRequest $organisationSponsorRequest): OrganisationSponsor;

    public function nextIdentity(): UuidInterface;

    public function save(OrganisationSponsor $organisationSponsor): void;
}
