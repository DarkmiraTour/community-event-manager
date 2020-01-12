<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

final class ContactFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager): void
    {
        $nextAddress = 0;

        for ($i = 0; $i < 10; $i++) {
            $contact = new Contact();

            $contact
                ->setFirstName($this->faker->firstName)
                ->setLastName($this->faker->lastName)
                ->setEmail($this->faker->email)
                ->setPhoneNumber($this->faker->phoneNumber)
            ;

            if ($this->faker->boolean) {
                $contact->addAddress($this->getReference('address-'.($nextAddress++)));
            }
            if ($this->faker->boolean) {
                $contact->addAddress($this->getReference('address-'.($nextAddress++)));
            }

            $this->setReference("contact-$i", $contact);
            $manager->persist($contact);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AddressFixtures::class,
        ];
    }
}
