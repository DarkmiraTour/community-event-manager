<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Speaker;
use App\Repository\Event\EventRepository;
use App\Repository\SpeakerRepositoryInterface;
use App\Service\FileUploaderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\File;

final class SpeakerFixtures extends Fixture implements DependentFixtureInterface
{
    private $speakerRepository;
    private $eventRepository;
    private $fileUploader;
    public const DEFAULT_SPEAKER = [
        'Behat' => '82e7325c-36b3-4c33-a0e8-743c6013e008',
    ];

    public function __construct(
        SpeakerRepositoryInterface $speakerRepository,
        EventRepository $eventRepository,
        FileUploaderInterface $fileUploader
    ) {
        $this->speakerRepository = $speakerRepository;
        $this->eventRepository = $eventRepository;
        $this->fileUploader = $fileUploader;
    }

    public function load(ObjectManager $manager): void
    {
        $events = $this->eventRepository->findAll();
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $speaker = new  Speaker(
                $this->speakerRepository->nextIdentity(),
                $faker->name,
                $faker->title,
                $faker->email,
                $faker->sentences($faker->numberBetween(1, 4), true),
                $this->fileUploader->upload(new File($faker->image('/tmp', 240, 240))),
                $faker->boolean ? $faker->url : null,
                $faker->boolean ? $faker->url : null,
                $faker->boolean ? $faker->url : null,
                $faker->boolean ? $faker->url : null
            );
            $speaker->addAttendingEvent($events[$faker->numberBetween(0, count($events) - 1)]);
            $manager->persist($speaker);
        }

        // add one fixed Speaker to Behat test
        $speaker = new  Speaker(
            Uuid::fromString('82e7325c-36b3-4c33-a0e8-743c6013e008'),
            'Behat',
            'Mr',
            'test@gmail.com',
            'Behat is awesome',
            $this->fileUploader->upload(new File($faker->image('/tmp', 240, 240)))
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
