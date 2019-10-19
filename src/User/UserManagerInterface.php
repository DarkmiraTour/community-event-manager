<?php

declare(strict_types=1);

namespace App\User;

use App\User\Username\Username;

interface UserManagerInterface
{
    public function find(string $id): ?User;

    public function findOneBy(array $criteria): ?User;

    public function save(User $userEntity): void;

    public function remove(User $userEntity): void;

    public function create(string $email, string $username, string $plainPassword): User;

    public function updateUserInformation(User $user, string $emailAddress = null, Username $username = null): void;

    /** @return User[] */
    public function findAll(): array;
}
