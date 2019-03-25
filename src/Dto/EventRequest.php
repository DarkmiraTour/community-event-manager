<?php

declare(strict_types=1);

namespace App\Dto;

use App\ValueObject\DateRangeInFuture;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;
use App\Entity\Event;

final class EventRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="100")
     */
    public $name;

    public $address;

    /**
     * @Assert\NotBlank()
     * @Assert\Date()
     * @CustomAssert\DateInFuture()
     * @CustomAssert\DateRange()
     */
    public $startAt;

    /**
     * @Assert\NotBlank()
     * @Assert\Date()
     * @CustomAssert\DateInFuture()
     * @CustomAssert\DateRange()
     */
    public $endAt;

    public $description;

    public static function createFromEvent(Event $event): EventRequest
    {
        $eventDto = new self();
        $eventDto->name = $event->getName();
        $eventDto->description = $event->getDescription();
        $eventDto->address = $event->getAddress();
        $eventDto->startAt = $event->getStartAt();
        $eventDto->endAt = $event->getEndAt();

        return $eventDto;
    }

    public function updateEvent(Event $event): Event
    {
        $event->updateFromRequest($this->name, $this->address, new DateRangeInFuture($this->startAt, $this->endAt), $this->description);

        return $event;
    }
}
