<?php

declare(strict_types=1);

namespace App\Repository\SpecialSponsorship;

use App\Entity\SpecialSponsorship;
use App\Dto\SpecialSponsorshipRequest;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SpecialSponsorshipManager implements SpecialSponsorshipManagerInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SpecialSponsorship::class);
    }

    public function find(string $id): ?SpecialSponsorship
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param SpecialSponsorshipRequest $specialSponsorshipRequest
     * @return SpecialSponsorship
     * @throws \Exception
     */
    public function createFrom(SpecialSponsorshipRequest $specialSponsorshipRequest): SpecialSponsorship
    {
        return new SpecialSponsorship(
            $this->nextIdentity(),
            $specialSponsorshipRequest->label,
            $specialSponsorshipRequest->price,
            $specialSponsorshipRequest->description
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

    public function save(SpecialSponsorship $specialSponsorship): void
    {
        $this->entityManager->persist($specialSponsorship);
        $this->entityManager->flush();
    }

    public function remove(SpecialSponsorship $specialSponsorship): void
    {
        $this->entityManager->remove($specialSponsorship);
        $this->entityManager->flush();
    }
}
