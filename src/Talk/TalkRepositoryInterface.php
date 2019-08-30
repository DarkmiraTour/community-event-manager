<?php

declare(strict_types=1);

namespace App\Talk;

interface TalkRepositoryInterface
{
    public function save(Talk $talk): void;

    public function remove(Talk $talk): void;

    public function find(string $id): ?Talk;

    public function findAll(): array;
}
