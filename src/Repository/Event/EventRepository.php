<?php

declare(strict_types=1);

namespace App\Repository\Event;

use App\Dto\EventRequest;
use App\Entity\Event;
use App\ValueObject\DateRangeInFuture;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class EventRepository implements EventRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Event::class);
    }

    public function createFromRequest(EventRequest $eventRequest): Event
    {
        return new Event(
            $this->nextIdentity(),
            $eventRequest->name,
            $eventRequest->address,
            new DateRangeInFuture($eventRequest->startAt, $eventRequest->endAt),
            $eventRequest->description
        );
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(Event $event): void
    {
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->repository->findBy([], ['startAt' => 'asc']);
    }

    public function findById(string $id): ?Event
    {
        return $this->repository->find($id);
    }

    public function remove(Event $event): void
    {
        $this->entityManager->remove($event);
        $this->entityManager->flush();
    }
}
