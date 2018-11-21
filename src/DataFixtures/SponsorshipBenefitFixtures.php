<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\SponsorshipBenefit;
use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class SponsorshipBenefitFixtures extends Fixture
{
    public const NB_SPONSORSHIP_BENEFIT = 14;

    private $sponsorshipBenefitManager;

    public function __construct(SponsorshipBenefitManagerInterface $sponsorshipBenefitManager)
    {
        $this->sponsorshipBenefitManager = $sponsorshipBenefitManager;
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        for ($iteratorIndex = 0; $iteratorIndex < self::NB_SPONSORSHIP_BENEFIT; $iteratorIndex++) {
            $sponsorshipBenefit = new SponsorshipBenefit(
                $this->sponsorshipBenefitManager->nextIdentity(),
                "Benefit {$iteratorIndex}",
                $iteratorIndex
            );
            $this->setReference("sponsorship-benefit-{$iteratorIndex}", $sponsorshipBenefit);
            $manager->persist($sponsorshipBenefit);
        }
        $manager->flush();
    }
}
