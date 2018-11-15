<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Repository\SpecialBenefit\SpecialBenefitManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class SpecialBenefitFixtures extends Fixture
{
    public const SPECIAL_BENEFIT_NBR = 10;

    private $specialBenefitManager;

    public function __construct(SpecialBenefitManagerInterface $specialBenefitManager)
    {
        $this->specialBenefitManager = $specialBenefitManager;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();
        for ($specialBenefitNbr = 0; $specialBenefitNbr < self::SPECIAL_BENEFIT_NBR; ++$specialBenefitNbr) {
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
