<?php

declare(strict_types=1);

namespace App\Sponsorship;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SponsorshipLevelBenefit
{
    private $id;
    /**
     * @Assert\NotNull()
     */
    private $sponsorshipLevel;
    /**
     * @Assert\NotNull()
     */
    private $sponsorshipBenefit;
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
