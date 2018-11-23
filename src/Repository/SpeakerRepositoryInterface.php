<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\SpeakerRequest;
use App\Entity\Speaker;
use Ramsey\Uuid\UuidInterface;

interface SpeakerRepositoryInterface
{
    public function save(Speaker $speaker): void;

    public function find(string $id): Speaker;

    public function remove(Speaker $speaker): void;

    public function findAll(): array;

    public function nextIdentity(): UuidInterface;

    public function createFromRequest(SpeakerRequest $speakerRequest): Speaker;
}
