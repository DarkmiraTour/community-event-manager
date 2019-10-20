<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevelBenefit;

use App\Sponsorship\SponsorshipBenefit;
use App\Sponsorship\SponsorshipLevel;
use App\Sponsorship\SponsorshipLevelBenefit;
use Symfony\Component\Validator\Constraints as Assert;

final class SponsorshipLevelBenefitRequest
{
    /**
     * @Assert\NotNull()
     */
    public $sponsorshipLevel;

    /**
     * @Assert\NotNull()
     */
    public $sponsorshipBenefit;

    /**
     * @Assert\Type(type="string")
     */
    public $content;

    public function __construct(SponsorshipLevel $sponsorshipLevel, SponsorshipBenefit $sponsorshipBenefit, ?string $content)
    {
        $this->sponsorshipLevel = $sponsorshipLevel;
        $this->sponsorshipBenefit = $sponsorshipBenefit;
        $this->content = $content;
    }

    public static function createFromEntity(SponsorshipLevelBenefit $sponsorshipLevelBenefit): SponsorshipLevelBenefitRequest
    {
        return new self(
            $sponsorshipLevelBenefit->getSponsorshipLevel(),
            $sponsorshipLevelBenefit->getSponsorshipBenefit(),
            $sponsorshipLevelBenefit->getContent()
        );
    }

    public function updateEntity(SponsorshipLevelBenefit $sponsorshipLevelBenefit): void
    {
        $sponsorshipLevelBenefit->updateSponsorshipLevelBenefit($this->sponsorshipLevel, $this->sponsorshipBenefit, $this->content);
    }
}
