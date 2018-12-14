<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\SponsorshipBenefit;
use Symfony\Component\Validator\Constraints as Assert;

final class SponsorshipBenefitRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    public $label;

    /**
     * @Assert\Type(type="integer")
     */
    public $position;

    public static function createFromEntity(SponsorshipBenefit $sponsorshipBenefit): SponsorshipBenefitRequest
    {
        $sponsorshipBenefitRequest = new self();
        $sponsorshipBenefitRequest->label = $sponsorshipBenefit->getLabel();
        $sponsorshipBenefitRequest->position = $sponsorshipBenefit->getPosition();

        return $sponsorshipBenefitRequest;
    }

    public function updateEntity(SponsorshipBenefit $sponsorshipBenefit): void
    {
        $sponsorshipBenefit->updateSponsorshipBenefit($this->label, $this->position);
    }
}
