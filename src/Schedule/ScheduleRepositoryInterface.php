<?php

declare(strict_types=1);

namespace App\Schedule;

use App\Entity\Event;
use App\Schedule\Create\CreateScheduleRequest;
use Ramsey\Uuid\UuidInterface;

interface ScheduleRepositoryInterface
{
    public function find(string $id): ?Schedule;

    /**
     * @return Schedule[]
     */
    public function findAll(): array;

    /**
     * @return Schedule[]
     */
    public function findBy(array $criteria = [], array $orderBy = [], int $limit = null, int $offset = null): array;

    public function createFrom(Event $event, CreateScheduleRequest $scheduleRequest): Schedule;

    public function nextIdentity(): UuidInterface;

    public function save(Schedule $schedule): void;

    public function remove(Schedule $schedule): void;

    /**
     * @return Schedule[]
     */
    public function findAllForSelectedEvent(): array;

    public function duplicate(Schedule $schedule): void;
}
