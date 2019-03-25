<?php

declare(strict_types=1);

namespace App\Repository\Event;

use App\Dto\EventRequest;
use App\Entity\Event;
use Ramsey\Uuid\UuidInterface;

interface EventRepositoryInterface
{
    public function createFromRequest(EventRequest $eventRequest): Event;

    public function nextIdentity(): UuidInterface;

    public function save(Event $event): void;

    public function remove(Event $event): void;

    public function findAll(): array;

    public function findById(string $id): ?Event;
}
