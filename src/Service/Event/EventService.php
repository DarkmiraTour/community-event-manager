<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\Event;
use App\Exceptions\NoEventSelectedException;
use App\Repository\Event\EventRepositoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class EventService implements EventServiceInterface
{
    public const EVENT_ID = 'event-id';
    public const EVENT_NAME = 'event-name';
    private $session;
    private $eventRepository;

    public function __construct(SessionInterface $session, EventRepositoryInterface $eventRepository)
    {
        $this->session = $session;
        $this->eventRepository = $eventRepository;
    }

    public function getSelectedEventName(): string
    {
        if (!$this->session->has(self::EVENT_NAME)) {
            throw new NoEventSelectedException();
        }

        return $this->session->get(self::EVENT_NAME);
    }

    public function getSelectedEventId(): string
    {
        if (!$this->session->has(self::EVENT_ID)) {
            throw new NoEventSelectedException();
        }

        return $this->session->get(self::EVENT_ID);
    }

    public function selectEvent(Event $event): void
    {
        $this->session->set(self::EVENT_NAME, $event->getName());
        $this->session->set(self::EVENT_ID, $event->getId());
    }

    public function isUserLoggedIn(): bool
    {
        return $this->session->isStarted();
    }

    public function unselectEvent(): void
    {
        $this->session->remove(self::EVENT_ID);
        $this->session->remove(self::EVENT_NAME);
    }

    public function isEventSelected(): bool
    {
        return $this->session->has(self::EVENT_ID);
    }

    public function getSelectedEvent(): Event
    {
        if (!$this->session->has(self::EVENT_ID)) {
            throw new NoEventSelectedException();
        }

        $event = $this->eventRepository->findById($this->session->get(self::EVENT_ID));

        if (null === $event) {
            $this->unselectEvent();
            throw new \RuntimeException('An inexisting event was in session. Session cleared.');
        }

        return $event;
    }

    public function checkIsEventDateExist(\DateTimeInterface $dateTime): bool
    {
        $event = $this->getSelectedEvent();
        $period = new \DatePeriod(
            $event->getStartAt(),
            new \DateInterval('P1D'),
            $event->getEndAt()
        );
        $availableDays = [];
        foreach ($period as $oneDay) {
            $availableDays[$oneDay->format('Y-m-d')] = $oneDay->format('Y-m-d');
        }
        $availableDays[$event->getEndAt()->format('Y-m-d')] = $event->getEndAt()->format('Y-m-d');

        if (in_array($dateTime->format('Y-m-d'), $availableDays)) {
            return true;
        }

        return false;
    }
}
