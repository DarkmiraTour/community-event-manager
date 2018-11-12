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
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();
        for ($sl = 0; $sl < self::NB_SPONSORSHIP_LEVEL; ++$sl) {
            $sponsorshipLevel = new SponsorshipLevel(
                $this->sponsorshipLevelManager->nextIdentity(),
                "Level {$sl}",
                $faker->randomFloat(2),
                $sl
            );
            $this->setReference("sponsorship-level-{$sl}", $sponsorshipLevel);
            $manager->persist($sponsorshipLevel);
        }
        $manager->flush();
    }
}
