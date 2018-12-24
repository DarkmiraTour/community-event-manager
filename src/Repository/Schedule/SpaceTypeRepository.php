<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Dto\SpaceTypeRequest;
use App\Entity\SpaceType;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SpaceTypeRepository implements SpaceTypeRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SpaceType::class);
    }

    public function find(string $id): ?SpaceType
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(SpaceType $spaceType): void
    {
        $this->entityManager->persist($spaceType);
        $this->entityManager->flush();
    }

    public function remove(SpaceType $spaceType): void
    {
        $this->entityManager->remove($spaceType);
        $this->entityManager->flush();
    }

    public function createFromRequest(SpaceTypeRequest $spaceTypeRequest): SpaceType
    {
        return new SpaceType(
            $this->nextIdentity(),
            $spaceTypeRequest->name,
            $spaceTypeRequest->description
        );
    }
}
