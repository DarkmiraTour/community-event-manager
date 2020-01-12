<?php

declare(strict_types=1);

namespace App\Sponsorship\Doctrine;

use App\Sponsorship\SponsorshipLevel\SponsorshipLevelManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

final class SponsorshipLevelFixtures extends Fixture
{
    public const SPONSORSHIP_LEVEL_NBR = 4;

    private $faker;
    private $sponsorshipLevelManager;

    public function __construct(SponsorshipLevelManagerInterface $sponsorshipLevelManager, Generator $faker)
    {
        $this->faker = $faker;
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
    }

    public function load(ObjectManager $manager): void
    {
        for ($sponsorshipLevelNbr = 0; $sponsorshipLevelNbr < self::SPONSORSHIP_LEVEL_NBR; $sponsorshipLevelNbr++) {
            $sponsorshipLevel = $this->sponsorshipLevelManager->createWith(
                "Level {$sponsorshipLevelNbr}",
                $this->faker->randomFloat(800, 15000),
                $sponsorshipLevelNbr
            );
            $this->setReference("sponsorship-level-{$sponsorshipLevelNbr}", $sponsorshipLevel);
            $manager->persist($sponsorshipLevel);
        }
        $manager->flush();
    }
}
