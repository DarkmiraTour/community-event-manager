<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\Title;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Schedule\Slot\SlotRepository")
 */
class Slot
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(length=50)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SlotType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * In minutes.
     * Used to optionnaly specify a duration
     * different than $end - $start for displaying or statistic purposes.
     *
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="time")
     */
    private $start;

    /**
     * @ORM\Column(name="time_end", type="time")
     */
    private $end;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Space", inversedBy="slots")
     * @ORM\JoinColumn(name="space_id", referencedColumnName="id")
     */
    private $space;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Talk", cascade={"persist"})
     */
    private $talk;

    public function __construct(UuidInterface $id, Title $titleObject, SlotType $slotType, int $duration, \DateTimeInterface $start, \DateTimeInterface $end, Space $space, ?Talk $talk)
    {
        $this->id = $id->toString();
        $this->title = $titleObject->__toString();
        $this->type = $slotType;
        $this->duration = $duration;
        $this->start = $start;
        $this->end = $end;
        $this->space = $space;
        $this->talk = $talk;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function getStart(): \DateTimeInterface
    {
        return $this->start;
    }

    public function getEnd(): \DateTimeInterface
    {
        return $this->end;
    }

    public function getType(): SlotType
    {
        return $this->type;
    }

    public function getSpace(): Space
    {
        return $this->space;
    }

    public function getTalk(): ?Talk
    {
        return $this->talk;
    }

    public function updateSlot(Title $titleObject, SlotType $slotType, \DateTimeInterface $start, \DateTimeInterface $end, Space $space, ?Talk $talk): void
    {
        $this->title = $titleObject->__toString();
        $this->type = $slotType;
        $this->start = $start;
        $this->end = $end;
        $this->space = $space;
        $this->talk = $talk;
    }
}
