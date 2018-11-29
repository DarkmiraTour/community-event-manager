<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SponsorshipLevelBenefit\SponsorshipLevelBenefitRepository")
 */
class SponsorshipLevelBenefit
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="SponsorshipLevel", inversedBy="sponsorshipLevelBenefits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sponsorshipLevel;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="SponsorshipBenefit", inversedBy="sponsorshipLevelBenefits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sponsorshipBenefit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

    public function __construct(UuidInterface $id, SponsorshipLevel $sponsorshipLevel, SponsorshipBenefit $sponsorshipBenefit, ?string $content)
    {
        $this->id = $id->toString();
        $this->sponsorshipLevel = $sponsorshipLevel;
        $this->sponsorshipBenefit = $sponsorshipBenefit;
        $this->content = $content;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSponsorshipLevel(): SponsorshipLevel
    {
        return $this->sponsorshipLevel;
    }

    public function setSponsorshipLevel(?SponsorshipLevel $sponsorshipLevel): self
    {
        $this->sponsorshipLevel = $sponsorshipLevel;

        return $this;
    }

    public function getSponsorshipBenefit(): SponsorshipBenefit
    {
        return $this->sponsorshipBenefit;
    }

    public function setSponsorshipBenefit(?SponsorshipBenefit $sponsorshipBenefit): self
    {
        $this->sponsorshipBenefit = $sponsorshipBenefit;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function updateSponsorshipLevelBenefit(SponsorshipLevel $sponsorshipLevel, SponsorshipBenefit $sponsorshipBenefit, ?string $content): void
    {
        $this->sponsorshipLevel = $sponsorshipLevel;
        $this->sponsorshipBenefit = $sponsorshipBenefit;
        $this->content = $content;
    }
}
