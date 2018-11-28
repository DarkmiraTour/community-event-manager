<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null): ?User;

    public function findOneBy(array $criteria, array $orderBy = null): ?User;

    public function createWith(string $email, string $username): User;

    public function save(User $user): void;

    public function remove(User $user): void;
}
