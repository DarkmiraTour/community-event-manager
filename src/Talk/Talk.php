<?php

declare(strict_types=1);

namespace App\Talk;

use App\Speaker\Speaker;
use Ramsey\Uuid\UuidInterface;

class Talk
{
    /** @var string */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var Speaker */
    private $speaker;

    public function __construct(UuidInterface $id, string $title, string $description, Speaker $speaker)
    {
        $this->id = $id->toString();
        $this->title = $title;
        $this->description = $description;
        $this->speaker = $speaker;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSpeaker(): Speaker
    {
        return $this->speaker;
    }

    public function setSpeaker(Speaker $speaker): self
    {
        $this->speaker = $speaker;

        return $this;
    }
}
