<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Schedule
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $day;

    /**
     * @ORM\OneToMany(targetEntity="Space", mappedBy="schedule")
     * @ORM\OrderBy({"visible"="DESC"})
     */
    private $spaces;

    public function __construct()
    {
        $this->spaces = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getDay(): ?\DateTime
    {
        return $this->day;
    }

    public function setDay(\DateTime $day): void
    {
        $this->day = $day;
    }

    public function getSpaces()
    {
        return $this->spaces;
    }

    public function setSpaces(ArrayCollection $spaces): void
    {
        $this->spaces = $spaces;
    }
}
