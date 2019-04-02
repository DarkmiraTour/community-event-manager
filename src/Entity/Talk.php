<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity()
 */
class Talk
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Speaker::class, inversedBy="talks", cascade={"persist"})
     */
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

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSpeaker(): Speaker
    {
        return $this->speaker;
    }

    public function setSpeaker($speaker): self
    {
        $this->speaker = $speaker;

        return $this;
    }
}
