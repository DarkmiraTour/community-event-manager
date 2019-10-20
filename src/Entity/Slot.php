<?php

declare(strict_types=1);

namespace App\Entity;

use App\Talk\Talk;
use App\ValueObject\Title;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

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

    public function __construct(
        UuidInterface $id,
        Title $titleObject,
        int $duration,
        \DateTimeInterface $start,
        \DateTimeInterface $end,
        SlotType $slotType = null,
        Space $space = null
    ) {
        $this->id = $id->toString();
        $this->title = $titleObject->__toString();
        $this->duration = $duration;
        $this->start = $start;
        $this->end = $end;
        $this->type = $slotType;
        $this->space = $space;
    }

    /**
     * @ORM\OneToOne(targetEntity="App\Talk\Talk", cascade={"persist"})
     */
    private $talk;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

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

    public function setTitle(Title $title): void
    {
        $this->title = $title->__toString();
    }

    /**
     * @return int
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

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

    public function setEnd(\DateTimeInterface $end): void
    {
        $this->end = $end;
    }

    public function getType(): SlotType
    {
        return $this->type;
    }

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

    public function setSpace(Space $space): void
    {
        $this->space = $space;
    }

    public function getTalk(): ?Talk
    {
        return $this->talk;
    }

    public function setTalk(?Talk $talk): self
    {
        $this->talk = $talk;

        return $this;
    }
}
