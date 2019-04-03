<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity()
 */
class Space
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SpaceType", inversedBy="spaces")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Schedule", inversedBy="spaces")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id")
     */
    private $schedule;

    /**
     * @ORM\Column(length=50)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Slot", mappedBy="space", cascade={"all"})
     */
    private $slots;

    public function __construct()
    {
        $this->slots = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    public function getType(): ?SpaceType
    {
        return $this->type;
    }

    public function setType(SpaceType $type): void
    {
        $this->type = $type;
    }

    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(Schedule $schedule): void
    {
        $this->schedule = $schedule;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSlots()
    {
        return $this->slots;
    }

    public function setSlots(ArrayCollection $slots): void
    {
        $this->slots = $slots;
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
        $this->slots = $this->getSlots();
        $slotClone = new ArrayCollection();

        foreach ($this->slots as $item) {
            $itemClone = clone $item;
            $itemClone->setId($this->nextIdentity()->toString());
            $itemClone->setSpace($this);
            $slotClone->add($itemClone);
        }
        $this->slots = $slotClone;
    }
}
