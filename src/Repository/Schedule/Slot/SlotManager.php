<?php

declare(strict_types=1);

namespace App\Repository\Schedule\Slot;

use App\Entity\Slot;
use App\Dto\SlotRequest;
use App\Entity\SlotType;
use App\Entity\Space;
use App\Entity\Talk;
use App\Exceptions\SlotNotFoundException;

final class SlotManager implements SlotManagerInterface
{
    private $repository;

    public function __construct(SlotRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $id): Slot
    {
        return $this->checkEntity($this->repository->find($id));
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria = [], array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function createFrom(SlotRequest $slotRequest): Slot
    {
        $duration = $this->calculatesDuration($slotRequest->start, $slotRequest->end);

        return $this->repository->createSlot($slotRequest->title, $slotRequest->type, $duration, $slotRequest->start, $slotRequest->end, $slotRequest->space, $slotRequest->talk);
    }

    public function createWith(string $title, SlotType $slotType, \DateTimeInterface $start, \DateTimeInterface $end, Space $space, Talk $talk): Slot
    {
        $duration = $this->calculatesDuration($start, $end);

        return $this->repository->createSlot($title, $slotType, $duration, $start, $end, $space, $talk);
    }

    public function save(Slot $slot): void
    {
        $this->repository->save($slot);
    }

    public function remove(Slot $slot): void
    {
        $this->repository->remove($slot);
    }

    private function checkEntity(?Slot $slot): Slot
    {
        if (!$slot) {
            throw new SlotNotFoundException();
        }

        return $slot;
    }

    private function calculatesDuration(\DateTimeInterface $start, \DateTimeInterface $end): int
    {
        $diff = $end->diff($start);
        $duration = ($diff->h * 60) + $diff->i;

        return $duration;
    }
}
