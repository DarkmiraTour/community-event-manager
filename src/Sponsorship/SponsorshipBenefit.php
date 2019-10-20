<?php

declare(strict_types=1);

namespace App\Sponsorship;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SponsorshipBenefit
{
    private $id;
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $label;
    private $sponsorshipLevelBenefits;
    /**
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

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
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
        if ($sponsorshipLevelBenefit->getSponsorshipBenefit() === $this) {
            $sponsorshipLevelBenefit->setSponsorshipBenefit(null);
        }

        return $this;
    }

    public function updateSponsorshipBenefit(string $label, ?int $position): void
    {
        $this->label = $label;
        $this->position = $position;
    }
}
