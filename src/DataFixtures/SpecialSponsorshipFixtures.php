<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\SpecialSponsorship;
use App\Repository\SpecialSponsorship\SpecialSponsorshipManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class SpecialSponsorshipFixtures extends Fixture
{
    public const NB_SPECIAL_SPONSORSHIP = 10;

    private $specialSponsorshipManager;

    public function __construct(SpecialSponsorshipManagerInterface $specialSponsorshipManager)
    {
        $this->specialSponsorshipManager = $specialSponsorshipManager;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();
        for ($ss = 0; $ss < self::NB_SPECIAL_SPONSORSHIP; ++$ss) {
            $specialSponsorship = new SpecialSponsorship(
                $this->specialSponsorshipManager->nextIdentity(),
                "Special Package {$ss}",
                $faker->randomFloat(2),
                $faker->text()
            );
            $manager->persist($specialSponsorship);
        }
        $manager->flush();
    }
}
