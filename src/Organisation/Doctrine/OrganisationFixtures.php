<?php

declare(strict_types=1);

namespace App\Organisation\Doctrine;

use App\DataFixtures\ContactFixtures;
use App\DataFixtures\EventFixture;
use App\Organisation\Organisation;
use App\Organisation\OrganisationRepositoryInterface;
use App\Repository\Event\EventRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

final class OrganisationFixtures extends Fixture implements DependentFixtureInterface
{
    private $repository;
    private $eventRepository;
    private $faker;

    public function __construct(OrganisationRepositoryInterface $repository, EventRepositoryInterface $eventRepository, Generator $faker)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager): void
    {
        $events = $this->eventRepository->findAll();

        for ($i = 0; $i < 10; $i++) {
            $uuid = $this->repository->nextIdentity();
            $organisation = new Organisation(
                $uuid,
                $this->faker->company,
                "http://{$this->faker->domainName}",
                $this->getReference("contact-$i")
            );

            if ($this->faker->boolean) {
                $organisation->setComment($this->faker->sentence);
            }

            $organisation->addSponsoredEvent($events[$this->faker->numberBetween(0, count($events) - 1)]);
            $manager->persist($organisation);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixture::class,
            ContactFixtures::class,
        ];
    }
}
