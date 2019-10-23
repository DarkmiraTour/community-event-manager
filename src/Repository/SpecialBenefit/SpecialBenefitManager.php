<?php

declare(strict_types=1);

namespace App\Repository\SpecialBenefit;

use App\Dto\SpecialBenefitRequest;
use App\Entity\SpecialBenefit;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class SpecialBenefitManager implements SpecialBenefitManagerInterface
{
    private $repository;

    public function __construct(SpecialBenefitRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $id): SpecialBenefit
    {
        return $this->checkEntity($this->repository->find($id));
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function createFrom(SpecialBenefitRequest $specialBenefitRequest): SpecialBenefit
    {
        return $this->repository->createSpecialBenefit($specialBenefitRequest->label, $specialBenefitRequest->price, $specialBenefitRequest->description);
    }

    public function createWith(string $label, float $price, string $description): SpecialBenefit
    {
        return $this->repository->createSpecialBenefit($label, $price, $description);
    }

    public function save(SpecialBenefit $specialBenefit): void
    {
        $this->repository->save($specialBenefit);
    }

    public function remove(SpecialBenefit $specialBenefit): void
    {
        $this->repository->remove($specialBenefit);
    }

    private function checkEntity(?SpecialBenefit $specialBenefit): SpecialBenefit
    {
        if (!$specialBenefit) {
            throw new NotFoundHttpException();
        }

        return $specialBenefit;
    }
}
