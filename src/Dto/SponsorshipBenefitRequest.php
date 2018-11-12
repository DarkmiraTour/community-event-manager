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

    public function __construct(string $label = null, int $position = null)
    {
        $this->label = $label;
        $this->position = $position;
    }

    public static function createFromEntity(SponsorshipBenefit $sponsorshipBenefit): SponsorshipBenefitRequest
    {
        return new SponsorshipBenefitRequest(
            $sponsorshipBenefit->getLabel(),
            $sponsorshipBenefit->getPosition()
        );
    }
    public function updateEntity(SponsorshipBenefit $sponsorshipBenefit): void
    {
        $sponsorshipBenefit->setLabel($this->label);
        $sponsorshipBenefit->setPosition($this->position);
    }
}
