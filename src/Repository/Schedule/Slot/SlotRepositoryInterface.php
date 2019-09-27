<?php

declare(strict_types=1);

namespace App\Repository\Schedule\Slot;

use App\Entity\Slot;
use App\Entity\SlotType;
use App\Entity\Space;
use App\Entity\Talk;

interface SlotRepositoryInterface
{
    public function createSlot(string $title, SlotType $slotType, int $duration, \DateTimeInterface $start, \DateTimeInterface $end, Space $space, ?Talk $talk): Slot;

    public function save(Slot $slot): void;

    public function remove(Slot $slot): void;

    public function find($id, $lockMode = null, $lockVersion = null): ?Slot;

    public function findAll(): array;

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    public function slotExistsForThisSpaceAndTime(Slot $slot): void;
}
