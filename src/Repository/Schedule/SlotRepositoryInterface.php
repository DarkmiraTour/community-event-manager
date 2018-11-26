<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Dto\SlotRequest;
use App\Entity\Slot;
use Ramsey\Uuid\UuidInterface;

interface SlotRepositoryInterface
{
    public function find(string $id): ?Slot;

    /**
     * @return Slot[]
     */
    public function findAll();

    public function createFrom(SlotRequest $slotRequest): Slot;

    public function nextIdentity(): UuidInterface;

    public function save(Slot $slot): void;

    public function remove(Slot $slot): void;
}
