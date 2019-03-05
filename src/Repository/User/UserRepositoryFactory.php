<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Exceptions\User\UnableToCreateUserException;
use App\Exceptions\ValueObject\Username\InvalidUsernameException;
use App\ValueObject\Username;
use Ramsey\Uuid\Uuid;
use App\Entity\User;

final class UserRepositoryFactory
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
