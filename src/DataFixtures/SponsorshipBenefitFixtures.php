<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class SponsorshipBenefitFixtures extends Fixture
{
    public const SPONSORSHIP_BENEFIT_NBR = 10;

    private $sponsorshipBenefitManager;

    public function __construct(SponsorshipBenefitManagerInterface $sponsorshipBenefitManager)
    {
        $this->sponsorshipBenefitManager = $sponsorshipBenefitManager;
    }

    public function load(ObjectManager $manager): void
    {
        for ($sponsorshipBenefitNbr = 0; $sponsorshipBenefitNbr < self::SPONSORSHIP_BENEFIT_NBR; $sponsorshipBenefitNbr++) {
            $sponsorshipBenefit = $this->sponsorshipBenefitManager->createWith(
                "Benefit {$sponsorshipBenefitNbr}",
                $sponsorshipBenefitNbr
            );
            $this->setReference("sponsorship-benefit-{$sponsorshipBenefitNbr}", $sponsorshipBenefit);
            $manager->persist($sponsorshipBenefit);
        }
        $manager->flush();
    }
}
