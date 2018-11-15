<?php

declare(strict_types=1);

namespace App\Repository\SpecialBenefit;

use App\Entity\SpecialBenefit;
use Ramsey\Uuid\UuidInterface;

interface SpecialBenefitRepositoryInterface
{
    /**
     * @param mixed    $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     * @return SpecialBenefit|null
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?SpecialBenefit;

    /**
     * @return SpecialBenefit[]
     */
    public function findAll();

    public function nextIdentity(): UuidInterface;

    public function save(SpecialBenefit $specialBenefit): void;

    public function remove(SpecialBenefit $specialBenefit): void;
}
