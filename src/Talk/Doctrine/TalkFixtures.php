<?php

declare(strict_types=1);

namespace App\Talk\Doctrine;

use App\DataFixtures\SpeakerFixtures;
use App\Repository\SpeakerRepositoryInterface;
use App\Talk\Create\TalkFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class TalkFixtures extends Fixture implements DependentFixtureInterface
{
    private $talkFactory;
    private $speakerRepository;

    public function __construct(TalkFactory $talkFactory, SpeakerRepositoryInterface $speakerRepository)
    {
        $this->talkFactory = $talkFactory;
        $this->speakerRepository = $speakerRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $speakers = $this->speakerRepository->findAll();
        $faker = Faker::create();

        for ($iterationCount = 0; $iterationCount < 10; $iterationCount++) {
            $speakerIndex = $faker->numberBetween(0, count($speakers) - 1);

            $talk = $this->talkFactory->createWith(
                $faker->sentence,
                $faker->paragraphs(3, true),
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
