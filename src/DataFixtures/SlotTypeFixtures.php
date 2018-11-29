<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\SlotType;
use App\Repository\Schedule\SlotTypeRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class SlotTypeFixtures extends Fixture
{
    private $slotTypeRepository;

    public function __construct(SlotTypeRepositoryInterface $slotTypeRepository)
    {
        $this->slotTypeRepository = $slotTypeRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $types = [
            0 => 'Talk',
            1 => 'Keynote',
            2 => 'Panel Discussion',
            3 => 'Coffee Break',
            4 => 'Other',
        ];

        for ($i = 0; $i <= 4; $i++) {
            $slotType = new SlotType();
            $slotType->setId(
                $this->slotTypeRepository->nextIdentity()->toString()
            );
            $slotType->setDescription($types[$i]);

            $manager->persist($slotType);
        }

        $manager->flush();
    }
}
