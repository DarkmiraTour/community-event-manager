<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Repository\SpecialBenefit\SpecialBenefitManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class SpecialBenefitFixtures extends Fixture
{
    private $specialBenefitManager;

    public function __construct(SpecialBenefitManagerInterface $specialBenefitManager)
    {
        $this->specialBenefitManager = $specialBenefitManager;
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();
        for ($specialBenefitNbr = 0; $specialBenefitNbr < 10; $specialBenefitNbr++) {
            $specialBenefit = $this->specialBenefitManager->createWith(
                "Special Package {$specialBenefitNbr}",
                $faker->randomFloat(2),
                $faker->text()
            );
            $manager->persist($specialBenefit);
        }
        $manager->flush();
    }
}
