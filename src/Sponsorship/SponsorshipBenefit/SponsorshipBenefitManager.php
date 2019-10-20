<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipBenefit;

use App\Sponsorship\SponsorshipBenefit;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class SponsorshipBenefitManager implements SponsorshipBenefitManagerInterface
{
    private $repository;

    public function __construct(SponsorshipBenefitRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $id): SponsorshipBenefit
    {
        return $this->checkEntity($this->repository->find($id));
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function createFrom(SponsorshipBenefitRequest $sponsorshipBenefitRequest): SponsorshipBenefit
    {
        return $this->repository->createSponsorshipBenefit($sponsorshipBenefitRequest->label, $sponsorshipBenefitRequest->position);
    }

    public function createWith(string $label, ?int $position): SponsorshipBenefit
    {
        return $this->repository->createSponsorshipBenefit($label, $position);
    }

    public function save(SponsorshipBenefit $sponsorshipBenefit): void
    {
        $this->repository->save($sponsorshipBenefit);
    }

    public function remove(SponsorshipBenefit $sponsorshipBenefit): void
    {
        $this->repository->remove($sponsorshipBenefit);
    }

    public function switchPosition(string $move, string $id): SponsorshipBenefit
    {
        $sponsorshipBenefit = $this->find($id);

        $first_position = $sponsorshipBenefit->getPosition();
        $new_position = $move == 'up' ? ($first_position - 1) : ($first_position + 1);

        $new_sponsorshipBenefit = $this->repository->findOneBy(['position' => $new_position]);

        $sponsorshipBenefit->setPosition($new_position);
        $new_sponsorshipBenefit->setPosition($first_position);

        $this->save($sponsorshipBenefit);
        $this->save($new_sponsorshipBenefit);

        return $new_sponsorshipBenefit;
    }

    public function getMaxPosition(): ?int
    {
        return (int) $this->repository->getMaxPosition();
    }

    public function getOrderedList(): array
    {
        return $this->repository->findBy([], ['position' => 'asc']);
    }

    private function checkEntity(?SponsorshipBenefit $sponsorshipBenefit): SponsorshipBenefit
    {
        if (!$sponsorshipBenefit) {
            throw new NotFoundHttpException();
        }

        return $sponsorshipBenefit;
    }
}
