<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;
use App\Entity\Address;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            $address = new Address(
                $faker->word,
                $faker->streetAddress,
                $faker->secondaryAddress,
                $faker->postcode,
                $faker->city
            );

            $this->setReference("address-$i", $address);
            $manager->persist($address);
        }

        $manager->flush();
    }
}
