<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Dto\EventRequest;
use App\Repository\Event\EventRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class EventFixture extends Fixture implements DependentFixtureInterface
{
    private $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();
        $nextYear = (int) date('Y') + 1;
        $nextAddress = 0;

        for ($iterationCount = 0; $iterationCount < 3; $iterationCount++) {
            $eventRequest = new EventRequest();
            $eventRequest->name = $faker->company;
            $eventRequest->address = $this->getReference('address-'.($nextAddress++));
            $eventRequest->description = $faker->text(50);
            $eventRequest->startAt = $faker->dateTimeBetween("{$nextYear}-01-01", "{$nextYear}-12-31");
            $eventRequest->endAt = new \DateTime($eventRequest->startAt->format('Y-m-d'));
            $eventRequest->endAt->add(new \DateInterval('P3D'));

            $event = $this->eventRepository->createFromRequest($eventRequest);
            $manager->persist($event);
        }

        $eventRequest = new EventRequest();
        $eventRequest->name = 'DarkmiraTour Behat';
        $eventRequest->address = $this->getReference('address-'.($nextAddress));
        $eventRequest->description = $faker->text(50);
        $eventRequest->startAt = $faker->dateTimeBetween("{$nextYear}-01-01", "{$nextYear}-12-31");
        $eventRequest->endAt = new \DateTime($eventRequest->startAt->format('Y-m-d'));
        $eventRequest->endAt->add(new \DateInterval('P3D'));

        $event = $this->eventRepository->createFromRequest($eventRequest);
        $manager->persist($event);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AddressFixtures::class,
        ];
    }
}
