<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\SpecialBenefit;
use Symfony\Component\Validator\Constraints as Assert;

final class SpecialBenefitRequest
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

    public static function createFromEntity(SpecialBenefit $specialBenefit): SpecialBenefitRequest
    {
        return new self(
            $specialBenefit->getLabel(),
            $specialBenefit->getPrice(),
            $specialBenefit->getDescription()
        );
    }
    public function updateEntity(SpecialBenefit $specialBenefit): void
    {
        $specialBenefit->setAll($this->label, $this->price, $this->description);
    }
}
