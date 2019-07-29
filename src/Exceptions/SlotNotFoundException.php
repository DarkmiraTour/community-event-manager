<?php

declare(strict_types=1);

namespace App\Exceptions;

final class SlotNotFoundException extends \LogicException
{
    public function __construct()
    {
        parent::__construct('Slot not found.');
    }
}
