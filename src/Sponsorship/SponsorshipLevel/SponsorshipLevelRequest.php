<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevel;

use App\Sponsorship\SponsorshipLevel;
use Symfony\Component\Validator\Constraints as Assert;

final class SponsorshipLevelRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    public $label;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     */
    public $price;

    /**
     * @Assert\Type(type="integer")
     */
    public $position;

    public static function createFromEntity(SponsorshipLevel $sponsorshipLevel): SponsorshipLevelRequest
    {
        $sponsorshipLevelRequest = new self();
        $sponsorshipLevelRequest->label = $sponsorshipLevel->getLabel();
        $sponsorshipLevelRequest->price = $sponsorshipLevel->getPrice();
        $sponsorshipLevelRequest->position = $sponsorshipLevel->getPosition();

        return $sponsorshipLevelRequest;
    }

    public function updateEntity(SponsorshipLevel $sponsorshipLevel): void
    {
        $sponsorshipLevel->updateSponsorshipLevel($this->label, $this->price, $this->position);
    }
}
