<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipBenefit;

use App\Entity\SponsorshipBenefit;
use App\Dto\SponsorshipBenefitRequest;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SponsorshipBenefitManager implements SponsorshipBenefitManagerInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SponsorshipBenefit::class);
    }

    public function find(string $id): ?SponsorshipBenefit
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param SponsorshipBenefitRequest $sponsorshipBenefitRequest
     *
     * @return SponsorshipBenefit
     *
     * @throws \Exception
     */
    public function createFrom(SponsorshipBenefitRequest $sponsorshipBenefitRequest): SponsorshipBenefit
    {
        return new SponsorshipBenefit(
            $this->nextIdentity(),
            $sponsorshipBenefitRequest->label,
            $sponsorshipBenefitRequest->position
        );
    }

    /**
     * @return UuidInterface
     *
     * @throws \Exception
     */
    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(SponsorshipBenefit $sponsorshipBenefit): void
    {
        $this->entityManager->persist($sponsorshipBenefit);
        $this->entityManager->flush();
    }

    public function remove(SponsorshipBenefit $sponsorshipBenefit): void
    {
        $this->entityManager->remove($sponsorshipBenefit);
        $this->entityManager->flush();
    }

    public function switchPosition(string $move, string $id): SponsorshipBenefit
    {
        $sponsorshipBenefit = $this->find($id);

        $first_position = $sponsorshipBenefit->getPosition();
        $new_position = $move == 'up' ? ($first_position - 1) : ($first_position + 1);

        $new_sponsorshipBenefit = $this->repository->findOneBy(['position' => $new_position]);

        $sponsorshipBenefit->setPosition($new_position);
        $new_sponsorshipBenefit->setPosition($first_position);

        $this->entityManager->persist($sponsorshipBenefit);
        $this->entityManager->persist($new_sponsorshipBenefit);
        $this->entityManager->flush();

        return $new_sponsorshipBenefit;
    }

    /**
     * @return int|null
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function getMaxPosition(): ?int
    {
        return (int) $this->repository->getMaxPosition();
    }

    /**
     * @return SponsorshipBenefit[]
     */
    public function getOrderedList()
    {
        return $this->repository->findBy([], ['position' => 'asc']);
    }
}
