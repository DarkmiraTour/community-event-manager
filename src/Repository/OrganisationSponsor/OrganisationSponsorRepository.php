<?php

declare(strict_types=1);

namespace App\Repository\OrganisationSponsor;

use App\Dto\OrganisationSponsorRequest;
use App\Entity\OrganisationSponsor;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class OrganisationSponsorRepository implements OrganisationSponsorRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(OrganisationSponsor::class);
    }

    public function find(string $id): ?OrganisationSponsor
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria = [], array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function createFrom(OrganisationSponsorRequest $organisationSponsorRequest): OrganisationSponsor
    {
        return new OrganisationSponsor(
            $this->nextIdentity(),
            $organisationSponsorRequest->specialBenefit,
            $organisationSponsorRequest->sponsorshipLevel
        );
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(OrganisationSponsor $organisationSponsor): void
    {
        $this->entityManager->persist($organisationSponsor);
        $this->entityManager->flush();
    }
}
