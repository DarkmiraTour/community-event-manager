<?php

declare(strict_types=1);

namespace App\Repository\Schedule\Slot;

use App\Entity\Slot;
use App\Dto\SlotRequest;
use App\Entity\SlotType;
use App\Entity\Space;
use App\Entity\Talk;
use App\Exceptions\SlotNotFoundException;
use App\Service\Slot\SlotTimeCalculator;

final class SlotManager implements SlotManagerInterface
{
    private $repository;
    private $slotTimeCalculator;

    public function __construct(SlotRepositoryInterface $repository, SlotTimeCalculator $slotTimeCalculator)
    {
        $this->repository = $repository;
        $this->slotTimeCalculator = $slotTimeCalculator;
    }

    public function find(string $id): Slot
    {
        $slot = $this->repository->find($id);

        if (null === $slot) {
            throw new SlotNotFoundException();
        }

        return $slot;
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
        $duration = $this->slotTimeCalculator->calculatesDuration($slotRequest->start, $slotRequest->end);

        return $this->repository->createSlot(
            $slotRequest->title,
            $slotRequest->type,
            $duration,
            $slotRequest->start,
            $slotRequest->end,
            $slotRequest->space,
            $slotRequest->talk
        );
    }

    public function createWith(string $title, SlotType $slotType, \DateTimeInterface $start, \DateTimeInterface $end, Space $space, Talk $talk): Slot
    {
        $duration = $this->slotTimeCalculator->calculatesDuration($start, $end);

        return $this->repository->createSlot(
            $title,
            $slotType,
            $duration,
            $start,
            $end,
            $space,
            $talk
        );
    }

    public function save(Slot $slot): void
    {
        $this->repository->save($slot);
    }

    public function remove(Slot $slot): void
    {
        $this->repository->remove($slot);
    }
}
