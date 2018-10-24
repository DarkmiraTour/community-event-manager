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
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        for ($sb = 0; $sb < self::NB_SPONSORSHIP_BENEFIT; ++$sb) {
            $sponsorshipBenefit = new SponsorshipBenefit(
                $this->sponsorshipBenefitManager->nextIdentity(),
                "Benefit {$sb}",
                $sb
            );
            $this->setReference("sponsorship-benefit-{$sb}", $sponsorshipBenefit);
            $manager->persist($sponsorshipBenefit);
        }
        $manager->flush();
    }
}
