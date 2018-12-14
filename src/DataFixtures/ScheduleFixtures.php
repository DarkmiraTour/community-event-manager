<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Schedule;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class ScheduleFixtures extends Fixture
{
    private $scheduleRepository;

    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 2; $i++) {
            $schedule = new Schedule();
            $schedule->setId(
                $this->scheduleRepository->nextIdentity()->toString()
            );
            $schedule->setDay($faker->dateTimeThisMonth);

            $manager->persist($schedule);
        }
        $manager->flush();
    }
}
