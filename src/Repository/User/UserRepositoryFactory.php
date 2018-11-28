<?php

declare(strict_types=1);

namespace App\Repository\User;

use Ramsey\Uuid\Uuid;
use App\Entity\User;

final class UserRepositoryFactory
{
    public static function create(string $email, string $username): User
    {
        return new User(Uuid::uuid4(), $email, $username);
    }
}