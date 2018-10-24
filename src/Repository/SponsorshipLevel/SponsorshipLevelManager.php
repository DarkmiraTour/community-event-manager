<?php

declare(strict_types=1);

namespace App\Repository\SponsorshipLevel;

use App\Entity\SponsorshipLevel;
use App\Dto\SponsorshipLevelRequest;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SponsorshipLevelManager implements SponsorshipLevelManagerInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SponsorshipLevel::class);
    }

    public function find(string $id): ?SponsorshipLevel
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param SponsorshipLevelRequest $sponsorshipLevelRequest
     * @return SponsorshipLevel
     * @throws \Exception
     */
    public function createFrom(SponsorshipLevelRequest $sponsorshipLevelRequest): SponsorshipLevel
    {
        return new SponsorshipLevel(
            $this->nextIdentity(),
            $sponsorshipLevelRequest->label,
            $sponsorshipLevelRequest->price,
            $sponsorshipLevelRequest->position
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

    public function save(SponsorshipLevel $sponsorshipLevel): void
    {
        $this->entityManager->persist($sponsorshipLevel);
        $this->entityManager->flush();
    }

    public function remove(SponsorshipLevel $sponsorshipLevel): void
    {
        $this->entityManager->remove($sponsorshipLevel);
        $this->entityManager->flush();
    }
    /**
     * @return SponsorshipLevel[]
     */
    public function getOrderedList()
    {
        return $this->repository->findBy([], ['position' => 'asc']);
    }

    public function switchPosition(string $move, string $id): SponsorshipLevel
    {
        $sponsorshipLevel = $this->find($id);

        $first_position = $sponsorshipLevel->getPosition();
        $new_position = $move == 'left' ? ($first_position - 1) : ($first_position + 1);

        $new_sponsorshipLevel = $this->repository->findOneBy(['position' => $new_position]);

        $sponsorshipLevel->setPosition($new_position);
        $new_sponsorshipLevel->setPosition($first_position);

        $this->entityManager->persist($sponsorshipLevel);
        $this->entityManager->persist($new_sponsorshipLevel);
        $this->entityManager->flush();

        return $new_sponsorshipLevel;
    }

    /**
     * @return int|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMaxPosition(): ?int
    {
        return (int) $this->repository->getMaxPosition();
    }
}
