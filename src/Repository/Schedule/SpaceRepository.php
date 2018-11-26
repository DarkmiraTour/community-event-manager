<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Dto\SpaceRequest;
use App\Entity\Space;
use App\Repository\Space\SpaceRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SpaceRepository implements SpaceRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Space::class);
    }

    public function find(string $id): ?Space
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function createFrom(SpaceRequest $spaceRequest): Space
    {

    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(Space $space): void
    {
        $this->entityManager->persist($space);
        $this->entityManager->flush();
    }

    public function remove(Space $space): void
    {
        $this->entityManager->remove($space);
        $this->entityManager->flush();
    }
}
