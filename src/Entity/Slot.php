<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Slot
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(length=50)
     */
    private $title;

    /**
     * @var SlotType
     * @ORM\ManyToOne(targetEntity="App\Entity\SlotType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="time")
     */
    private $start;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(name="time_end", type="time")
     */
    private $end;

    /**
     * @var Space
     * @ORM\ManyToOne(targetEntity="App\Entity\Space", inversedBy="slots")
     * @ORM\JoinColumn(name="space_id", referencedColumnName="id")
     */
    private $space;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    /**
     * @param \DateTimeInterface $start
     */
    public function setStart(\DateTimeInterface $start): void
    {
        $this->start = $start;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    /**
     * @param \DateTimeInterface $end
     */
    public function setEnd(\DateTimeInterface $end): void
    {
        $this->end = $end;
    }

    /**
     * @return SlotType
     */
    public function getType(): SlotType
    {
        return $this->type;
    }

    /**
     * @param SlotType $type
     */
    public function setType(SlotType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Space
     */
    public function getSpace(): ?Space
    {
        return $this->space;
    }

    /**
     * @param Space $space
     */
    public function setSpace(Space $space): void
    {
        $this->space = $space;
    }
}
