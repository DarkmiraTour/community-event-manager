<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Schedule;
use App\Repository\Event\EventRepositoryInterface;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

final class ScheduleFixtures extends Fixture implements DependentFixtureInterface
{
    private $scheduleRepository;
    private $eventRepository;
    private $faker;

    public function __construct(ScheduleRepositoryInterface $scheduleRepository, EventRepositoryInterface $eventRepository, Generator $faker)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->eventRepository = $eventRepository;
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager): void
    {
        $events = $this->eventRepository->findAll();

        for ($i = 0; $i < 5; $i++) {
            /** @var Event $selectedEvent */
            $selectedEvent = $events[$this->faker->numberBetween(0, count($events) - 1)];
            $schedule = new Schedule($selectedEvent);
            $schedule->setId(
                $this->scheduleRepository->nextIdentity()->toString()
            );
            $schedule->setDay($this->faker->dateTimeBetween($selectedEvent->getStartAt(), $selectedEvent->getEndAt()));

            $manager->persist($schedule);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixture::class,
        ];
    }
}
