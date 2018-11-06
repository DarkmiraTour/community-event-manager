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

    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param ScheduleRequest $scheduleRequest
     * @return Schedule
     * @throws \Exception
     */
    public function createFrom(ScheduleRequest $scheduleRequest): Schedule
    {
        $schedule = new Schedule();
        $schedule->setId($this->nextIdentity()->toString());
        $schedule->setDay(
            new \DateTime($scheduleRequest->day)
        );
        $schedule->setPlace($scheduleRequest->place);

        return $schedule;
    }

    /**
     * @return UuidInterface
     * @throws \Exception
     */
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