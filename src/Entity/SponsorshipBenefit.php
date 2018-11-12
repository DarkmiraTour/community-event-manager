<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SponsorshipBenefit\SponsorshipBenefitRepository")
 */
class SponsorshipBenefit
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
     * @ORM\OneToMany(targetEntity="SponsorshipLevelBenefit", mappedBy="sponsorshipBenefit", orphanRemoval=true, cascade={"persist"})
     */
    private $sponsorshipLevelBenefits;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type="integer")
     */
    private $position;

    public function __construct(UuidInterface $id, string $label, int $position)
    {
        $this->id = $id->toString();
        $this->label = $label;
        $this->position = $position;
        $this->sponsorshipLevelBenefits = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
            $sponsorshipLevelBenefit->setSponsorshipBenefit($this);
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
