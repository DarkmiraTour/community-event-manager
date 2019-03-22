<?php

declare(strict_types=1);

namespace App\Repository\Schedule\Slot;

use App\Entity\Slot;
use App\Dto\SlotRequest;
use App\Entity\SlotType;
use App\Entity\Space;
use App\Entity\Talk;

interface SlotManagerInterface
{
    public function find(string $id): Slot;

    public function findAll(): array;

    public function findBy(array $criteria = [], array $orderBy = [], int $limit = null, int $offset = null): array;

    public function createFrom(SlotRequest $slotRequest): Slot;

    public function createWith(string $title, SlotType $slotType, \DateTimeInterface $start, \DateTimeInterface $end, Space $space, Talk $talk): Slot;

    public function save(Slot $slot): void;

    public function remove(Slot $slot): void;
}
