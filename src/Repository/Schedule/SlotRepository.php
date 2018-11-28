<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Dto\SlotRequest;
use App\Entity\Schedule;
use App\Entity\Slot;
use App\Entity\Space;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SlotRepository implements SlotRepositoryInterface
{
    private $entityManager;
    private $repository;
    private $spaceRepository;
    private $scheduleRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Slot::class);
        $this->spaceRepository = $entityManager->getRepository(Space::class);
        $this->scheduleRepository = $entityManager->getRepository(Schedule::class);
    }

    public function find(string $id): ?Slot
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function createFrom(SlotRequest $slotRequest): Slot
    {
        $slot = new Slot();
        $slot->setId($this->nextIdentity()->toString());
        $slot->setDuration((int) $slotRequest->duration);
        $slot->setTitle($slotRequest->title);
        $slot->setType($slotRequest->type);
        $slot->setStart($slotRequest->start);
        $slot->setEnd($slotRequest->end);
        $slot->setSpace(
            $this->spaceRepository->find($slotRequest->space)
        );

        return $slot;
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(Slot $slot): void
    {
        $this->entityManager->persist($slot);
        $this->entityManager->flush();
    }

    public function remove(Slot $slot): void
    {
        $this->entityManager->remove($slot);
        $this->entityManager->flush();
    }
}
