<?php

declare(strict_types=1);

namespace App\Repository\Organisation;

use App\Dto\OrganisationRequest;
use App\Entity\Organisation;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class DoctrineOrganisationRepository implements OrganisationRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Organisation::class);
    }

    public function find(string $id): ?Organisation
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function createFrom(OrganisationRequest $organisationRequest): Organisation
    {
        return new Organisation(
            $this->nextIdentity(),
            $organisationRequest->name,
            $organisationRequest->website,
            $organisationRequest->contact,
            $organisationRequest->comment
        );
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(Organisation $organisation): void
    {
        $this->entityManager->persist($organisation);
        $this->entityManager->flush();
    }

    public function remove(Organisation $organisation): void
    {
        $this->entityManager->remove($organisation);
        $this->entityManager->flush();
    }
}
