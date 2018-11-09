<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\SpecialSponsorship;
use Symfony\Component\Validator\Constraints as Assert;

final class SpecialSponsorshipRequest
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
     * @Assert\NotBlank()
     */
    public $description;

    public function __construct(string $label = null, float $price = null, string $description = null)
    {
        $this->label = $label;
        $this->price = $price;
        $this->description = $description;
    }

    public static function createFromEntity(SpecialSponsorship $specialSponsorship): SpecialSponsorshipRequest
    {
        return new SpecialSponsorshipRequest(
            $specialSponsorship->getLabel(),
            $specialSponsorship->getPrice(),
            $specialSponsorship->getDescription()
        );
    }
    public function updateEntity(SpecialSponsorship $specialSponsorship): void
    {
        $specialSponsorship->setLabel($this->label);
        $specialSponsorship->setPrice($this->price);
        $specialSponsorship->setDescription($this->description);
    }
}
