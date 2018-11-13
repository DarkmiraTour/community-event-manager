<?php

declare(strict_types=1);

namespace App\Repository\SpecialBenefit;

use App\Entity\SpecialBenefit;
use App\Dto\SpecialBenefitRequest;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SpecialBenefitManager implements SpecialBenefitManagerInterface
{
    private $repository;

    public function __construct(SpecialBenefitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $id): ?SpecialBenefit
    {
        return $this->repository->find($id);
    }

    /**
     * @return SpecialBenefit[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param SpecialBenefitRequest $specialBenefitRequest
     * @return SpecialBenefit
     * @throws \Exception
     */
    public function createFrom(SpecialBenefitRequest $specialBenefitRequest): SpecialBenefit
    {
        return new SpecialBenefit(
            $this->nextIdentity(),
            $specialBenefitRequest->label,
            $specialBenefitRequest->price,
            $specialBenefitRequest->description
        );
    }

    /**
     * @return UuidInterface
     * @throws \Exception
     */
    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    /**
     * @param SpecialBenefit $specialBenefit
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(SpecialBenefit $specialBenefit): void
    {
        $this->repository->save($specialBenefit);
    }

    /**
     * @param SpecialBenefit $specialBenefit
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(SpecialBenefit $specialBenefit): void
    {
        $this->repository->remove($specialBenefit);
    }
}
