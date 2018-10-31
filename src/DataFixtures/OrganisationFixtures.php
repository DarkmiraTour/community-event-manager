<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Organisation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class OrganisationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $organisation = (new Organisation())
                ->setName($faker->company)
                ->setWebsite("http://{$faker->domainName}");
            if ($faker->boolean) {
                $organisation->setAddress($faker->address);
            }
            if ($faker->boolean) {
                $organisation->setComment($faker->sentence);
            }

            $manager->persist($organisation);
        }

        $manager->flush();
    }
}
