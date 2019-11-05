<?php

declare(strict_types=1);

namespace App\Space\SpaceType;

use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class SpaceType
{
    private $id;

    private $name;

    private $description;

    private $spaces;

    public function __construct(UuidInterface $id, string $name, string $description)
    {
        $this->id = $id->toString();
        $this->name = $name;
        $this->description = $description;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getSpaces(): Collection
    {
        return $this->spaces;
    }

    public function setSpaces(Collection $spaces): self
    {
        $this->spaces = $spaces;

        return $this;
    }
}
