<?php

declare(strict_types=1);

namespace App\Speaker\Doctrine;

use App\DataFixtures\EventFixture;
use App\Repository\Event\EventRepository;
use App\Service\FileUploaderInterface;
use App\Speaker\Speaker;
use App\Speaker\SpeakerRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\File;

final class SpeakerFixtures extends Fixture implements DependentFixtureInterface
{
    private $speakerRepository;
    private $eventRepository;
    private $faker;
    private $fileUploader;
    public const DEFAULT_SPEAKER = [
        'Behat' => '82e7325c-36b3-4c33-a0e8-743c6013e008',
    ];

    public function __construct(
        SpeakerRepositoryInterface $speakerRepository,
        EventRepository $eventRepository,
        FileUploaderInterface $fileUploader,
        Generator $faker
    ) {
        $this->speakerRepository = $speakerRepository;
        $this->eventRepository = $eventRepository;
        $this->fileUploader = $fileUploader;
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager): void
    {
        $events = $this->eventRepository->findAll();

        for ($i = 0; $i < 10; $i++) {
            $speaker = new  Speaker(
                $this->speakerRepository->nextIdentity(),
                $this->faker->name,
                $this->faker->title,
                $this->faker->email,
                $this->faker->sentences($this->faker->numberBetween(1, 4), true),
                $this->fileUploader->upload(new File($this->faker->image('/tmp', 240, 240))),
                $this->faker->boolean ? $this->faker->url : null,
                $this->faker->boolean ? $this->faker->url : null,
                $this->faker->boolean ? $this->faker->url : null,
                $this->faker->boolean ? $this->faker->url : null
            );
            $speaker->addAttendingEvent($events[$this->faker->numberBetween(0, count($events) - 1)]);
            $manager->persist($speaker);
        }

        // add one fixed Speaker to Behat test
        $speaker = new  Speaker(
            Uuid::fromString('82e7325c-36b3-4c33-a0e8-743c6013e008'),
            'Behat',
            'Mr',
            'test@gmail.com',
            'Behat is awesome',
            $this->fileUploader->upload(new File($this->faker->image('/tmp', 240, 240)))
        );
        $manager->persist($speaker);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixture::class,
        ];
    }
}
