<?php

namespace App\DataFixtures;

use App\Entity\Organisation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class OrganisationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

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
