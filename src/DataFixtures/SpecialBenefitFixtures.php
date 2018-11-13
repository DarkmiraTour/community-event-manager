<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\SpecialBenefit;
use App\Repository\SpecialBenefit\SpecialBenefitManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class SpecialBenefitFixtures extends Fixture
{
    public const NB_SPECIAL_BENEFIT = 10;

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
        for ($nbSpecialBenefit = 0; $nbSpecialBenefit < self::NB_SPECIAL_BENEFIT; ++$nbSpecialBenefit) {
            $specialBenefit = new SpecialBenefit(
                $this->specialBenefitManager->nextIdentity(),
                "Special Package {$nbSpecialBenefit}",
                $faker->randomFloat(2),
                $faker->text()
            );
            $manager->persist($specialBenefit);
        }
        $manager->flush();
    }
}
