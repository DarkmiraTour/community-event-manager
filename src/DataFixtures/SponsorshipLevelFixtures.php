<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class SponsorshipLevelFixtures extends Fixture
{
    public const SPONSORSHIP_LEVEL_NBR = 4;

    private $sponsorshipLevelManager;

    public function __construct(SponsorshipLevelManagerInterface $sponsorshipLevelManager)
    {
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();
        for ($sponsorshipLevelNbr = 0; $sponsorshipLevelNbr < self::SPONSORSHIP_LEVEL_NBR; $sponsorshipLevelNbr++) {
            $sponsorshipLevel = $this->sponsorshipLevelManager->createWith(
                "Level {$sponsorshipLevelNbr}",
                $faker->randomFloat(800, 15000),
                $sponsorshipLevelNbr
            );
            $this->setReference("sponsorship-level-{$sponsorshipLevelNbr}", $sponsorshipLevel);
            $manager->persist($sponsorshipLevel);
        }
        $manager->flush();
    }
}
