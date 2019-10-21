<?php

declare(strict_types=1);

namespace App\Page;

use Ramsey\Uuid\UuidInterface;

class Page
{
    private $id;
    private $title;
    private $content;
    private $background;

    public function __construct(UuidInterface $id, string $title, string $content, string $background)
    {
        $this->id = $id->toString();
        $this->title = $title;
        $this->content = $content;
        $this->background = $background;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getBackground(): string
    {
        return $this->background;
    }

    public function updatePage(string $title, string $content, string $background): void
    {
        $this->title = $title;
        $this->content = $content;
        $this->background = $background;
    }
}
