<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Dto\ScheduleRequest;
use App\Entity\Schedule;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ScheduleRepository implements ScheduleRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Schedule::class);
    }

    public function find(string $id): ?Schedule
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

    public function createFrom(ScheduleRequest $scheduleRequest): Schedule
    {
        $schedule = new Schedule();
        $schedule->setId($this->nextIdentity()->toString());
        $schedule->setDay($scheduleRequest->day);

        return $schedule;
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(Schedule $schedule): void
    {
        $this->entityManager->persist($schedule);
        $this->entityManager->flush();
    }

    public function remove(Schedule $schedule): void
    {
        $this->entityManager->remove($schedule);
        $this->entityManager->flush();
    }
}
