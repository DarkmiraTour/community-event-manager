<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Speaker;
use App\Repository\SpeakerRepositoryInterface;
use App\Service\FileUploaderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\HttpFoundation\File\File;

final class SpeakerFixtures extends Fixture
{
    private $speakerRepository;
    private $fileUploader;

    public function __construct(
        SpeakerRepositoryInterface $speakerRepository,
        FileUploaderInterface $fileUploader
    ) {
        $this->speakerRepository = $speakerRepository;
        $this->fileUploader = $fileUploader;
    }

    public function load(ObjectManager $manager): void
    {
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

            $manager->persist($speaker);
        }

        $manager->flush();
    }
}
