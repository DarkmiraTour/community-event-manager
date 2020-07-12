<?php

declare(strict_types=1);

namespace App\Space\Doctrine;

use App\Entity\Schedule;
use App\Space\Create\CreateSpaceRequest;
use App\Space\Space;
use App\Space\SpaceRepositoryInterface;
use App\Space\SpaceType\SpaceType;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SpaceRepository implements SpaceRepositoryInterface
{
    private $entityManager;
    private $repository;
    private $spaceTypeRepository;
    private $scheduleRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Space::class);
        $this->spaceTypeRepository = $entityManager->getRepository(SpaceType::class);
        $this->scheduleRepository = $entityManager->getRepository(Schedule::class);
    }

    public function find(string $id): ?Space
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria = [], array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function createFrom(CreateSpaceRequest $spaceRequest): Space
    {
        $space = new Space();
        $space->setId($this->nextIdentity()->toString());
        $space->setVisible($spaceRequest->visible);
        $space->setName($spaceRequest->name);
        $space->setType(
            $this->spaceTypeRepository->find($spaceRequest->type)
        );
        $space->setSchedule(
            $this->scheduleRepository->find($spaceRequest->schedule)
        );

        return $space;
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
