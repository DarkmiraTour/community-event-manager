<?php

declare(strict_types=1);

namespace App\Sponsorship\SpecialBenefit;

use App\Sponsorship\SpecialBenefit;

interface SpecialBenefitRepositoryInterface
{
    public function createSpecialBenefit(string $label, float $price, string $description): SpecialBenefit;

    /**
     * @param int|null $lockMode
     * @param int|null $lockVersion
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?SpecialBenefit;

    public function findAll(): array;

    public function save(SpecialBenefit $specialBenefit): void;

    public function remove(SpecialBenefit $specialBenefit): void;
}
