<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Dto\SlotTypeRequest;
use App\Entity\SlotType;

interface SlotTypeRepositoryInterface
{
    public function find(string $id): ?SlotType;

    /**
     * @return SlotType[]
     */
    public function findAll(): array;

    /**
     * @return SlotType[]
     */
    public function findBy(array $criteria = [], array $orderBy = [], int $limit = null, int $offset = null): array;

    public function createFrom(SlotTypeRequest $slotRequest): SlotType;

    public function createWith(string $description): SlotType;

    public function save(SlotType $slotType): void;

    public function remove(SlotType $slotType): void;
}
