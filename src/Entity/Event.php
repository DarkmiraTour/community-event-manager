<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\DateRangeInFuture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="events")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", cascade={"persist", "remove"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrganisationSponsor", mappedBy="event")
     */
    private $organisationSponsors;

    public function __construct(
        UuidInterface $id,
        string $name,
        Address $address,
        DateRangeInFuture $dateRange,
        ?string $description = null
    ) {
        $this->id = $id->toString();
        $this->name = $name;
        $this->address = $address;
        $this->description = $description;
        $this->startAt = $dateRange->getStartAt();
        $this->endAt = $dateRange->getEndAt();
        $this->organisationSponsors = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStartAt(): \DateTimeInterface
    {
        return $this->startAt;
    }

    public function getEndAt(): \DateTimeInterface
    {
        return $this->endAt;
    }

    public function updateFromRequest(
        string $name,
        Address $address,
        DateRangeInFuture $dateRange,
        ?string $description
    ): void {
        $this->name = $name;
        $this->address = $address;
        $this->description = $description;
        $this->startAt = $dateRange->getStartAt();
        $this->endAt = $dateRange->getEndAt();
    }

    public function getOrganisationSponsors(): Collection
    {
        return $this->organisationSponsors;
    }

    public function addOrganisationSponsor(OrganisationSponsor $organisationSponsor): void
    {
        $this->organisationSponsors->add($organisationSponsor);
    }
}
