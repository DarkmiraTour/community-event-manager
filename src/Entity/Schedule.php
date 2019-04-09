<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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
     * @ORM\OneToMany(targetEntity="Space", mappedBy="schedule", cascade={"all"})
     * @ORM\OrderBy({"visible"="DESC"})
     */
    private $spaces;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class)
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
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

    public function getDay(): ?\DateTimeInterface
    {
        return $this->day;
    }

    public function setDay(\DateTimeInterface $day): void
    {
        $this->day = $day;
    }

    public function getSpaces(): Collection
    {
        return $this->spaces;
    }

    public function setSpaces(ArrayCollection $spaces): void
    {
        $this->spaces = $spaces;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function __clone()
    {
        if (!$this->id) {
            return;
        }
        $this->setId($this->nextIdentity()->toString());
        $this->spaces = $this->getSpaces();
        $spaceClone = new ArrayCollection();
        foreach ($this->spaces as $item) {
            $itemClone = clone $item;
            $itemClone->setId($this->nextIdentity()->toString());
            $itemClone->setSchedule($this);
            $spaceClone->add($itemClone);
        }
        $this->spaces = $spaceClone;
    }
}
