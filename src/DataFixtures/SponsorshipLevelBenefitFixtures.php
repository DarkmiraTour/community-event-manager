<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\SponsorshipLevelBenefit;
use App\Repository\SponsorshipLevelBenefit\SponsorshipLevelBenefitManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class SponsorshipLevelBenefitFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    private $sponsorshipLevelBenefitManager;

    public function __construct(SponsorshipLevelBenefitManagerInterface $sponsorshipLevelBenefitManager)
    {
        $this->faker = Faker::create();
        $this->sponsorshipLevelBenefitManager = $sponsorshipLevelBenefitManager;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        for ($sl = 0; $sl < SponsorshipLevelFixtures::NB_SPONSORSHIP_LEVEL; ++$sl) {
            $this->createSponsorshipLevelBenefit($manager, $sl);
        }
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param int $sponsorshipLevelIndex
     * @throws \Exception
     */
    private function createSponsorshipLevelBenefit(ObjectManager $manager, int $sponsorshipLevelIndex)
    {
        $nbSponsorship = $this->faker->numberBetween(1, SponsorshipBenefitFixtures::NB_SPONSORSHIP_BENEFIT);
        for ($sb = 0; $sb < $nbSponsorship; ++$sb) {
            $sponsorshipLevelBenefit = new SponsorshipLevelBenefit(
                $this->sponsorshipLevelBenefitManager->nextIdentity(),
                $this->getReference("sponsorship-level-{$sponsorshipLevelIndex}"),
                $this->getReference("sponsorship-benefit-{$sb}"),
                $this->faker->optional()->word
            );
            $manager->persist($sponsorshipLevelBenefit);
        }
    }

    public function getDependencies()
    {
        return [
            SponsorshipLevelFixtures::class,
            SponsorshipBenefitFixtures::class,
        ];
    }
}
