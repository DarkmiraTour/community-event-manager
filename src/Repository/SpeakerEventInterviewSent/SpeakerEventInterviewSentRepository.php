<?php

declare(strict_types=1);

namespace App\Repository\SpeakerEventInterviewSent;

use App\Entity\Event;
use App\Entity\Speaker;
use App\Entity\SpeakerEventInterviewSent;
use Doctrine\ORM\EntityManagerInterface;

final class SpeakerEventInterviewSentRepository implements SpeakerEventRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SpeakerEventInterviewSent::class);
    }

    public function save(SpeakerEventInterviewSent $event): void
    {
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(string $id): ?SpeakerEventInterviewSent
    {
        return $this->repository->find($id);
    }

    public function findAllSpeakersByEvent(Event $event): array
    {
        $result = $this->repository->findBy(['event' => $event]);

        $speakers = [];
        foreach ($result as $speakerEventInterviewSent) {
            $speakers[] = $speakerEventInterviewSent->getSpeaker();
        }

        return $speakers;
    }

    public function findAllEventsBySpeaker(Speaker $speaker): array
    {
        $result = $this->repository->findBy(['speaker' => $speaker]);

        $events = [];
        foreach ($result as $speakerEventInterviewSent) {
            $events[] = $speakerEventInterviewSent->getEvent();
        }

        return $events;
    }

    public function findBySpeakerAndEvent(Speaker $speaker, Event $event): ?SpeakerEventInterviewSent
    {
        return $this->repository->findOneBy(['speaker' => $speaker, 'event' => $event]);
    }

    public function remove(Event $event): void
    {
        $this->entityManager->remove($event);
        $this->entityManager->flush();
    }

    public function addAttendingEvent(Speaker $speaker, Event $event): void
    {
        if (null === $this->findBySpeakerAndEvent($speaker, $event)) {
            $speakerEvent = new SpeakerEventInterviewSent($speaker, $event);
            $this->save($speakerEvent);
        }
    }
}
