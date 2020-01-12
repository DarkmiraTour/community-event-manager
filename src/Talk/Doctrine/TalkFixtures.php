<?php

declare(strict_types=1);

namespace App\Talk\Doctrine;

use App\Speaker\Doctrine\SpeakerFixtures;
use App\Speaker\SpeakerRepositoryInterface;
use App\Talk\Create\TalkFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

final class TalkFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;
    private $talkFactory;
    private $speakerRepository;

    public function __construct(TalkFactory $talkFactory, SpeakerRepositoryInterface $speakerRepository, Generator $faker)
    {
        $this->faker = $faker;
        $this->talkFactory = $talkFactory;
        $this->speakerRepository = $speakerRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $speakers = $this->speakerRepository->findAll();

        for ($iterationCount = 0; $iterationCount < 10; $iterationCount++) {
            $speakerIndex = $this->faker->numberBetween(0, count($speakers) - 1);

            $talk = $this->talkFactory->createWith(
                $this->faker->sentence,
                $this->faker->paragraphs(3, true),
                $speakers[$speakerIndex]
            );

            $manager->persist($talk);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SpeakerFixtures::class,
        ];
    }
}
