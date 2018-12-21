<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\SlotType;
use Symfony\Component\Validator\Constraints as Assert;

final class SlotTypeRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $description;

    public static function createFromEntity(SlotType $slotType): SlotTypeRequest
    {
        $slotTypeRequest = new self();
        $slotTypeRequest->description = $slotType->getDescription();

        return $slotTypeRequest;
    }

    public function updateEntity(SlotType $slotType): void
    {
        $slotType->updateSlotType($this->description);
    }
}
