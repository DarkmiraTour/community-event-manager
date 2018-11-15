<?php

declare(strict_types=1);

namespace App\DataFixtures;

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
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        for ($sponsorshipLevelNbr = 0; $sponsorshipLevelNbr < SponsorshipLevelFixtures::SPONSORSHIP_LEVEL_NBR; $sponsorshipLevelNbr++) {
            $this->createSponsorshipLevelBenefit($manager, $sponsorshipLevelNbr);
        }
        $manager->flush();
    }

    private function createSponsorshipLevelBenefit(ObjectManager $manager, int $sponsorshipLevelNbr): void
    {
        $nbSponsorship = $this->faker->numberBetween(1, SponsorshipBenefitFixtures::SPONSORSHIP_BENEFIT_NBR);
        for ($sponsorshipLevelBenefitNbr = 0; $sponsorshipLevelBenefitNbr < $nbSponsorship; $sponsorshipLevelBenefitNbr++) {
            $sponsorshipLevelBenefit = $this->sponsorshipLevelBenefitManager->createWith(
                $this->getReference("sponsorship-level-{$sponsorshipLevelNbr}"),
                $this->getReference("sponsorship-benefit-{$sponsorshipLevelBenefitNbr}"),
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
