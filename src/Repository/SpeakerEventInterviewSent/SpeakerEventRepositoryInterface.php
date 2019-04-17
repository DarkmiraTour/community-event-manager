<?php

declare(strict_types=1);

namespace App\Repository\SpeakerEventInterviewSent;

use App\Entity\Event;
use App\Entity\Speaker;
use App\Entity\SpeakerEventInterviewSent;

interface SpeakerEventRepositoryInterface
{
    public function save(SpeakerEventInterviewSent $event): void;

    public function findAll(): array;

    public function findById(string $id): ?SpeakerEventInterviewSent;

    public function findBySpeakerAndEvent(Speaker $speaker, Event $event): ?SpeakerEventInterviewSent;

    public function remove(Event $event): void;

    public function addAttendingEvent(Speaker $speaker, Event $event): void;

    public function findAllSpeakersByEvent(Event $event): array;

    public function findAllEventsBySpeaker(Speaker $speaker): array;
}
