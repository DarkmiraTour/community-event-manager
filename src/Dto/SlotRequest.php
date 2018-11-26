<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Slot;
use App\Entity\SlotType;
use App\Entity\Space;
use Symfony\Component\Validator\Constraints as Assert;

final class SlotRequest
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $space;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $type;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public $duration;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $start;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $end;

    public function __construct(
        Space $space = null,
        SlotType $type = null,
        int $duration = 0,
        string $title = null,
        \DateTime $start = null,
        \DateTime $end = null
    ) {
        $this->space = $space;
        $this->type = $type;
        $this->duration = $duration;
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
    }

    public static function createFromEntity(Slot $slot): slotRequest
    {
        return new SlotRequest(
            $slot->getSpace(),
            $slot->getType(),
            $slot->getDuration(),
            $slot->getTitle(),
            $slot->getStart(),
            $slot->getEnd()
        );
    }

    public function updateSlot(Slot $slot): Slot
    {
        $slot->setSpace($this->space);
        $slot->setDuration((int) $this->duration);
        $slot->setType($this->type);
        $slot->setStart($this->start);
        $slot->setEnd($this->end);
        $slot->setTitle($this->title);

        return $slot;
    }
}
