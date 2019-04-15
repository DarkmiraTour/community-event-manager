<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity()
 */
class OrganisationSponsor
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisation", inversedBy="organisationSponsors")
     */
    private $organisation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="organisationSponsors")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SpecialBenefit", inversedBy="organisationSponsors")
     */
    private $specialBenefit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SponsorshipLevel", inversedBy="organisationSponsors")
     */
    private $sponsorshipLevel;

    public function __construct(UuidInterface $id, SpecialBenefit $specialBenefit = null, SponsorshipLevel $sponsorshipLevel = null)
    {
        $this->id = $id->toString();
        $this->specialBenefit = $specialBenefit;
        $this->sponsorshipLevel = $sponsorshipLevel;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }

    public function setOrganisation(?Organisation $organisation): self
    {
        $this->organisation = $organisation;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getSpecialBenefit(): ?SpecialBenefit
    {
        return $this->specialBenefit;
    }

    public function setSpecialBenefit(?SpecialBenefit $specialBenefit): self
    {
        $this->specialBenefit = $specialBenefit;

        return $this;
    }

    public function getSponsorshipLevel(): ?SponsorshipLevel
    {
        return $this->sponsorshipLevel;
    }

    public function setSponsorshipLevel(?SponsorshipLevel $sponsorshipLevel): self
    {
        $this->sponsorshipLevel = $sponsorshipLevel;

        return $this;
    }
}
