<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class SlotTypeRequest
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $description;

    public function __construct(string $description = null)
    {
        $this->description = $description;
    }
}
