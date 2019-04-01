<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Dto\ScheduleRequest;
use App\Entity\Event;
use App\Entity\Schedule;
use App\Exceptions\NoEventSelectedException;
use App\Service\Event\EventServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ScheduleRepository implements ScheduleRepositoryInterface
{
    private $entityManager;
    private $repository;
    private $eventService;

    public function __construct(EntityManagerInterface $entityManager, EventServiceInterface $eventService)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Schedule::class);
        $this->eventService = $eventService;
    }

    public function find(string $id): ?Schedule
    {
        if (!$this->eventService->isEventSelected()) {
            throw new NoEventSelectedException();
        }

        return $this->repository->findOneBy(['id' => $id, 'event' => $this->eventService->getSelectedEvent()]);
    }

    public function findAllForSelectedEvent(): array
    {
        if (!$this->eventService->isEventSelected()) {
            throw new NoEventSelectedException();
        }

        return $this->repository->findBy(['event' => $this->eventService->getSelectedEvent()]);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria = [], array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function createFrom(Event $event, ScheduleRequest $scheduleRequest): Schedule
    {
        $schedule = new Schedule($event);
        $schedule->setId($this->nextIdentity()->toString());
        $schedule->setDay($scheduleRequest->day);

        return $schedule;
    }

    public function findScheduleAndSlots(Event $event): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->from('App:Schedule', 'schedule')
            ->select('schedule, space, slot, slotType')
            ->leftJoin('schedule.spaces', 'space')
            ->leftJoin('space.slots', 'slot')
            ->leftJoin('slot.type', 'slotType')
            ->where('schedule.event = :event')
            ->orderBy('schedule.day')
            ->setParameter(':event', $event)
        ;

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
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

    public function duplicate(Schedule $schedule): void
    {
        $scheduleClone = clone $schedule;
        $this->entityManager->persist($scheduleClone);
        $this->entityManager->detach($schedule);
        $this->entityManager->flush();
    }
}
