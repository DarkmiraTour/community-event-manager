<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            $address = new Address();

            $address
                ->setName($faker->word)
                ->setStreetAddress($faker->streetAddress)
                ->setStreetAddressComplementary($faker->secondaryAddress)
                ->setPostalCode($faker->postcode)
                ->setCity($faker->city)
            ;

            $this->setReference("address-$i", $address);
            $manager->persist($address);
        }

        $manager->flush();
    }
}
