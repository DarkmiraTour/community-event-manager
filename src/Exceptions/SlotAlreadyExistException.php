<?php

declare(strict_types=1);

namespace App\Exceptions;

class SlotAlreadyExistException extends \LogicException
{
    protected $message = 'A slot already exists for this space and time';
}
