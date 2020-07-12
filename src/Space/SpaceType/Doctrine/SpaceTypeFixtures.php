<?php

declare(strict_types=1);

namespace App\Space\SpaceType\Doctrine;

use App\Space\SpaceType\SpaceType;
use App\Space\SpaceType\SpaceTypeRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class SpaceTypeFixtures extends Fixture
{
    private $spaceTypeRepository;

    public function __construct(SpaceTypeRepositoryInterface $spaceTypeRepository)
    {
        $this->spaceTypeRepository = $spaceTypeRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $types = [
            0 => ['name' => 'Room', 'description' => 'Room...'],
            1 => ['name' => 'Computer Lab', 'description' => 'Lab...'],
            2 => ['name' => 'Auditorium', 'description' => 'Auditorium...'],
        ];

        for ($i = 0; $i <= 2; $i++) {
            $spaceType = new SpaceType($this->spaceTypeRepository->nextIdentity(), $types[$i]['name'], $types[$i]['description']);
            $manager->persist($spaceType);
        }

        $manager->flush();
    }
}
