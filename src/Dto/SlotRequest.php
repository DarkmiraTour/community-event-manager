<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Slot;
use App\Entity\SlotType;
use App\Entity\Space;
use App\ValueObject\Title;
use App\Entity\Talk;
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

    public $talk;

    public function __construct(
        Space $space = null,
        SlotType $type = null,
        string $title = null,
        \DateTime $start = null,
        \DateTime $end = null,
        ?Talk $talk = null
    ) {
        $this->space = $space;
        $this->type = $type;
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
        $this->talk = $talk;
    }

    public static function createFromEntity(Slot $slot): slotRequest
    {
        return new SlotRequest(
            $slot->getSpace(),
            $slot->getType(),
            $slot->getTitle(),
            $slot->getStart(),
            $slot->getEnd(),
            $slot->getTalk()
        );
    }

    public function updateSlot(Slot $slot): Slot
    {
        $slot->setSpace($this->space);
        $slot->setType($this->type);
        $slot->setStart($this->start);
        $slot->setEnd($this->end);
        $slot->setTitle(new Title($this->title));
        $slot->setTalk($this->talk);

        return $slot;
    }
}
