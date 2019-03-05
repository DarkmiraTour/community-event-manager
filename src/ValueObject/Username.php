<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exceptions\ValueObject\Username\InvalidUsernameException;

final class Username
{
    private const CONSTRAINT = 'The username must be all alphanumeric with `_`, `-`, `.`, without spaces and be at least 5 characters long.';
    private const CONSTRAINT_REGEX = '/^[a-zA-Z0-9\._-]{5,}$/';
    private $username;

    public function __construct(string $username)
    {
        if (!preg_match(self::CONSTRAINT_REGEX, $username)) {
            throw new InvalidUsernameException(self::CONSTRAINT);
        }
        $this->username = $username;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    public static function getCreationConstraint(): string
    {
        return self::CONSTRAINT;
    }
}
