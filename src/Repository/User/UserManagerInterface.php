<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Entity\User;

interface UserManagerInterface
{
    public function find(string $id): ?User;

    public function findOneBy(array $criteria): ?User;

    public function save(User $userEntity): void;

    public function remove(User $userEntity): void;

    public function create(string $email, string $username, string $plainPassword): User;
}
