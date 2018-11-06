<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Speaker;
use App\Repository\SpeakerRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class SpeakerFixtures extends Fixture
{
    private $speakerRepository;

    public function __construct(SpeakerRepositoryInterface $speakerRepository)
    {
        $this->speakerRepository = $speakerRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $speaker = new  Speaker(
                $this->speakerRepository->nextIdentity(),
                $faker->name,
                $faker->title,
                $faker->email,
                $faker->sentences($faker->numberBetween(0, 4), true),
                '',
                $faker->boolean ? $faker->url : null,
                $faker->boolean ? $faker->url : null,
                $faker->boolean ? $faker->url : null,
                $faker->boolean ? $faker->url : null
            );

            $manager->persist($speaker);
        }

        $manager->flush();
    }
}
