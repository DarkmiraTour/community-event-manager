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

    public static function createFromEntity(SpecialBenefit $specialBenefit): SpecialBenefitRequest
    {
        $specialBenefitRequest = new self();
        $specialBenefitRequest->label = $specialBenefit->getLabel();
        $specialBenefitRequest->price = $specialBenefit->getPrice();
        $specialBenefitRequest->description = $specialBenefit->getDescription();

        return $specialBenefitRequest;
    }

    public function updateEntity(SpecialBenefit $specialBenefit): void
    {
        $specialBenefit->updateSpecialBenefit($this->label, $this->price, $this->description);
    }
}
