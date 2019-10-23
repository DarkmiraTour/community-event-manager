<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class ContactFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        $nextAddress = 0;

        for ($i = 0; $i < 10; $i++) {
            $contact = new Contact();

            $contact
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setPhoneNumber($faker->phoneNumber)
            ;

            if ($faker->boolean) {
                $contact->addAddress($this->getReference('address-'.($nextAddress++)));
            }
            if ($faker->boolean) {
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
