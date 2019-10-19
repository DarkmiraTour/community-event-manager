<?php

declare(strict_types=1);

namespace App\Speaker;

use Ramsey\Uuid\UuidInterface;

interface SpeakerRepositoryInterface
{
    public function save(Speaker $speaker): void;

    public function find(string $id): Speaker;

    public function remove(Speaker $speaker): void;

    public function findAll(): array;

    public function nextIdentity(): UuidInterface;

    public function createFromRequest(SpeakerRequest $speakerRequest): Speaker;

    public function createWith(string $name, string $email, string $title, string $biography, string $photoPath): Speaker;
}
