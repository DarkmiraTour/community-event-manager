<?php declare(strict_types=1);

namespace App\Repository;

use App\Dto\TalkRequest;
use App\Entity\Speaker;
use App\Entity\Talk;

interface TalkRepositoryInterface
{
    public function save(Talk $talk): void;

    public function remove(Talk $talk): void;

    public function find(string $id): ?Talk;

    public function findAll(): array;

    public function createFromRequest(TalkRequest $talkRequest): Talk;

    public function createWith(string $title, string $description, Speaker $speaker): Talk;
}
