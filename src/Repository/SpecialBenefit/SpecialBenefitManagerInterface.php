<?php

declare(strict_types=1);

namespace App\Repository\SpecialBenefit;

use App\Entity\SpecialBenefit;
use App\Dto\SpecialBenefitRequest;

interface SpecialBenefitManagerInterface
{
    public function find(string $id): SpecialBenefit;

    public function findAll(): array;

    public function createFrom(SpecialBenefitRequest $specialBenefitRequest): SpecialBenefit;

    public function createWith(string $label, float $price, string $description): SpecialBenefit;

    public function save(SpecialBenefit $specialBenefit): void;

    public function remove(SpecialBenefit $specialBenefit): void;
}
