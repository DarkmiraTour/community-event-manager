<?php

declare(strict_types=1);

namespace App\User\Username;

use Throwable;

class InvalidUsernameException extends \LogicException
{
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
