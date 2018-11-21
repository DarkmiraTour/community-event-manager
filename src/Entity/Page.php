<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 */
class Page
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
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
