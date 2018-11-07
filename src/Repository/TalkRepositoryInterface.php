<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Talk;
use Ramsey\Uuid\UuidInterface;

interface TalkRepositoryInterface
{
    public function save(Talk $talk): void;

    public function remove(Talk $talk): void;

    public function find(string $id): Talk;

    public function findAll(): array;

    public function nextIdentity(): UuidInterface;
}
