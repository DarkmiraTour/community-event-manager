<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Dto\SlotTypeRequest;
use App\Entity\SlotType;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SlotTypeRepository implements SlotTypeRepositoryInterface
{
    private $repository;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SlotType::class);
    }

    public function find(string $id): ?SlotType
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

    public function createFrom(SlotTypeRequest $slotRequest): SlotType
    {
        $slotType = new SlotType();
        $slotType->setId($this->nextIdentity()->toString());
        $slotType->setDescription($slotRequest->description);

        return $slotType;
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(SlotType $slotType): void
    {
        $this->entityManager->persist($slotType);
        $this->entityManager->flush();
    }

    public function remove(SlotType $slotType): void
    {
        $this->entityManager->remove($slotType);
        $this->entityManager->flush();
    }
}
