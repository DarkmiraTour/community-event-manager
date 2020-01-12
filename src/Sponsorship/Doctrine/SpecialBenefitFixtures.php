<?php

declare(strict_types=1);

namespace App\Sponsorship\Doctrine;

use App\Sponsorship\SpecialBenefit\SpecialBenefitManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

final class SpecialBenefitFixtures extends Fixture
{
    private $faker;
    private $specialBenefitManager;

    public function __construct(SpecialBenefitManagerInterface $specialBenefitManager, Generator $faker)
    {
        $this->faker = $faker;
        $this->specialBenefitManager = $specialBenefitManager;
    }

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        for ($specialBenefitNbr = 0; $specialBenefitNbr < 10; $specialBenefitNbr++) {
            $specialBenefit = $this->specialBenefitManager->createWith(
                "Special Package {$specialBenefitNbr}",
                $this->faker->randomFloat(2),
                $this->faker->text()
            );
            $manager->persist($specialBenefit);
        }
        $manager->flush();
    }
}
