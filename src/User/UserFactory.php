<?php

declare(strict_types=1);

namespace App\User;

use App\User\Create\UnableToCreateUserException;
use App\User\Username\InvalidUsernameException;
use App\User\Username\Username;
use Ramsey\Uuid\Uuid;

final class UserFactory
{
    public static function create(string $email, string $username): User
    {
        try {
            return new User(Uuid::uuid4(), $email, new Username($username));
        } catch (InvalidUsernameException | \InvalidArgumentException | \Exception $exception) {
            throw new UnableToCreateUserException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
