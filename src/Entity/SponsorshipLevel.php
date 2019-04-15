<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SponsorshipLevel\SponsorshipLevelRepository")
 */
class SponsorshipLevel
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="SponsorshipLevelBenefit", mappedBy="sponsorshipLevel", orphanRemoval=true, cascade={"persist"})
     */
    private $sponsorshipLevelBenefits;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrganisationSponsor", mappedBy="sponsorshipLevel")
     */
    private $organisationSponsors;

    public function __construct(UuidInterface $id, string $label, float $price, int $position)
    {
        $this->id = $id->toString();
        $this->label = $label;
        $this->price = $price;
        $this->position = $position;
        $this->sponsorshipLevelBenefits = new ArrayCollection();
        $this->organisationSponsors = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection|SponsorshipLevelBenefit[]
     */
    public function getSponsorshipLevelBenefits(): Collection
    {
        return $this->sponsorshipLevelBenefits;
    }

    public function addSponsorshipLevelBenefit(SponsorshipLevelBenefit $sponsorshipLevelBenefit): self
    {
        if (!$this->sponsorshipLevelBenefits->contains($sponsorshipLevelBenefit)) {
            $this->sponsorshipLevelBenefits[] = $sponsorshipLevelBenefit;
            $sponsorshipLevelBenefit->setSponsorshipLevel($this);
        }

        return $this;
    }

    public function removeSponsorshipLevelBenefit(SponsorshipLevelBenefit $sponsorshipLevelBenefit): self
    {
        if (!$this->sponsorshipLevelBenefits->contains($sponsorshipLevelBenefit)) {
            return $this;
        }

        $this->sponsorshipLevelBenefits->removeElement($sponsorshipLevelBenefit);
        if ($sponsorshipLevelBenefit->getSponsorshipLevel() === $this) {
            $sponsorshipLevelBenefit->setSponsorshipLevel(null);
        }

        return $this;
    }

    public function updateSponsorshipLevel(string $label, float $price, ?int $position): void
    {
        $this->label = $label;
        $this->price = $price;
        $this->position = $position;
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
