<?php

declare(strict_types=1);

namespace App\Talk\Create;

use App\Speaker\Speaker;
use App\Talk\Talk;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class TalkFactory
{
    public function createFromRequest(CreateTalkRequest $createTalkRequest): Talk
    {
        return new Talk(
            $this->nextIdentity(),
            $createTalkRequest->title,
            $createTalkRequest->description,
            $createTalkRequest->speaker
        );
    }

    public function createWith(string $title, string $description, Speaker $speaker): Talk
    {
        return new Talk(
            $this->nextIdentity(),
            $title,
            $description,
            $speaker
        );
    }

    private function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
