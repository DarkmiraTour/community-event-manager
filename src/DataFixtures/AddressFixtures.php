<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

final class AddressFixtures extends Fixture
{
    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $address = new Address();

            $address
                ->setName($this->faker->word)
                ->setStreetAddress($this->faker->streetAddress)
                ->setStreetAddressComplementary($this->faker->secondaryAddress)
                ->setPostalCode($this->faker->postcode)
                ->setCity($this->faker->city)
            ;

            $this->setReference("address-$i", $address);
            $manager->persist($address);
        }

        $manager->flush();
    }
}
