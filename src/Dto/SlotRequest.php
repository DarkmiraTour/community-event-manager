<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Slot;
use App\Validator\Constraints as CustomAssert;
use App\ValueObject\Title;
use Symfony\Component\Validator\Constraints as Assert;

final class SlotRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(max="50")
     */
    public $title;

    /**
     * @Assert\NotNull()
     */
    public $type;

    /**
     * @Assert\NotBlank()
     * @Assert\Time()
     */
    public $start;

    /**
     * @Assert\NotBlank()
     * @Assert\Time()
     * @CustomAssert\EventCanStartSlot()
     * @CustomAssert\EventLongerThan10MinutesSlot()
     */
    public $end;

    /**
     * @Assert\NotNull()
     */
    public $space;

    public $talk;

    public static function createFromSlot(Slot $slot): slotRequest
    {
        $slotRequest = new self();
        $slotRequest->title = $slot->getTitle();
        $slotRequest->type = $slot->getType();
        $slotRequest->start = $slot->getStart();
        $slotRequest->end = $slot->getEnd();
        $slotRequest->space = $slot->getSpace();
        $slotRequest->talk = $slot->getTalk();

        return $slotRequest;
    }

    public function updateSlot(Slot $slot): void
    {
        $slot->updateSlot(new Title($this->title), $this->type, $this->start, $this->end, $this->space, $this->talk);
    }
}
