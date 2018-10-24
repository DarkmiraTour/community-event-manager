<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\SponsorshipLevel;
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

    public function __construct(string $label = null, float $price = null, int $position = null)
    {
        $this->label = $label;
        $this->price = $price;
        $this->position = $position;
    }

    public static function createFromEntity(SponsorshipLevel $sponsorshipLevel): SponsorshipLevelRequest
    {
        return new SponsorshipLevelRequest(
            $sponsorshipLevel->getLabel(),
            $sponsorshipLevel->getPrice(),
            $sponsorshipLevel->getPosition()
        );
    }
    public function updateEntity(SponsorshipLevel $sponsorshipLevel): void
    {
        $sponsorshipLevel->setLabel($this->label);
        $sponsorshipLevel->setPrice($this->price);
        $sponsorshipLevel->setPosition($this->position);
    }
}
