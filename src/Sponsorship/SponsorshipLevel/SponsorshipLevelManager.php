<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevel;

use App\Sponsorship\SponsorshipLevel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class SponsorshipLevelManager implements SponsorshipLevelManagerInterface
{
    private $repository;

    public function __construct(SponsorshipLevelRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $id): SponsorshipLevel
    {
        return $this->checkEntity($this->repository->find($id));
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function createFrom(SponsorshipLevelRequest $sponsorshipLevelRequest): SponsorshipLevel
    {
        return $this->repository->createSponsorshipLevel($sponsorshipLevelRequest->label, $sponsorshipLevelRequest->price, $sponsorshipLevelRequest->position);
    }

    public function createWith(string $label, float $price, ?int $position): SponsorshipLevel
    {
        return $this->repository->createSponsorshipLevel($label, $price, $position);
    }

    public function save(SponsorshipLevel $sponsorshipLevel): void
    {
        $this->repository->save($sponsorshipLevel);
    }

    public function remove(SponsorshipLevel $sponsorshipLevel): void
    {
        $this->repository->remove($sponsorshipLevel);
    }

    public function getOrderedList(): array
    {
        return $this->repository->findBy([], ['position' => 'asc']);
    }

    public function switchPosition(string $move, string $id): SponsorshipLevel
    {
        $sponsorshipLevel = $this->find($id);

        $first_position = $sponsorshipLevel->getPosition();
        $new_position = $move === 'left' ? ($first_position - 1) : ($first_position + 1);

        $new_sponsorshipLevel = $this->repository->findOneBy(['position' => $new_position]);

        $sponsorshipLevel->setPosition($new_position);
        $new_sponsorshipLevel->setPosition($first_position);

        $this->save($sponsorshipLevel);
        $this->save($new_sponsorshipLevel);

        return $new_sponsorshipLevel;
    }

    public function getMaxPosition(): ?int
    {
        return (int) $this->repository->getMaxPosition();
    }

    private function checkEntity(?SponsorshipLevel $sponsorshipLevel): SponsorshipLevel
    {
        if (!$sponsorshipLevel) {
            throw new NotFoundHttpException();
        }

        return $sponsorshipLevel;
    }
}
