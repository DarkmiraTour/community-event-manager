<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\Event;

interface EventServiceInterface
{
    public function getSelectedEventName(): ?string;

    public function getSelectedEventId(): ?string;

    public function getSelectedEvent(): Event;

    public function selectEvent(Event $event): void;

    public function unselectEvent(): void;

    public function isUserLoggedIn(): bool;

    public function isEventSelected(): bool;

    public function checkIsEventDateExist(\DateTimeInterface $dateTime): bool;
}
