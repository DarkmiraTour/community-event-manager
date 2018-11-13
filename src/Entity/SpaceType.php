<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SpaceType
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(length=100)
     */
    private $name;

    /**
     * @ORM\Column()
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Space", mappedBy="type")
     */
    private $spaces;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getSpaces(): ?ArrayCollection
    {
        return $this->spaces;
    }

    public function setSpaces(ArrayCollection $spaces): void
    {
        $this->spaces = $spaces;
    }
}