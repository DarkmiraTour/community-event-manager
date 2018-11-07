<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Talk;
use App\Repository\TalkRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class TalkFixtures extends Fixture
{
    private $talkRepository;

    public function __construct(TalkRepositoryInterface $talkRepository)
    {
        $this->talkRepository = $talkRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $talk = new Talk(
                $this->talkRepository->nextIdentity(),
                $faker->sentence,
                $faker->paragraphs(3, true)
            );

            $manager->persist($talk);
        }

        $manager->flush();
    }
}
