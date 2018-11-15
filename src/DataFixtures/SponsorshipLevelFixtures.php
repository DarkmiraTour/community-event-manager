<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\SponsorshipLevel;
use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class SponsorshipLevelFixtures extends Fixture
{
    public const NB_SPONSORSHIP_LEVEL = 4;

    private $sponsorshipLevelManager;

    public function __construct(SponsorshipLevelManagerInterface $sponsorshipLevelManager)
    {
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();
        for ($iteratorIndex = 0; $iteratorIndex < self::NB_SPONSORSHIP_LEVEL; $iteratorIndex++) {
            $sponsorshipLevel = new SponsorshipLevel(
                $this->sponsorshipLevelManager->nextIdentity(),
                "Level {$iteratorIndex}",
                $faker->randomFloat(2),
                $iteratorIndex
            );
            $this->setReference("sponsorship-level-{$iteratorIndex}", $sponsorshipLevel);
            $manager->persist($sponsorshipLevel);
        }
        $manager->flush();
    }
}
