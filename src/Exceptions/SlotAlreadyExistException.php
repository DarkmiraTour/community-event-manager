<?php

declare(strict_types=1);

namespace App\Exceptions;

final class SlotAlreadyExistException extends \LogicException
{
    public function __construct()
    {
        parent::__construct('A slot already exists for this space and time');
    }
}
