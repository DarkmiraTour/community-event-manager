<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Repository\Schedule\SlotTypeRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class SlotTypeFixtures extends Fixture
{
    private $slotTypeRepository;
    private const TYPES = [
        0 => 'Talk',
        1 => 'Keynote',
        2 => 'Panel Discussion',
        3 => 'Coffee Break',
        4 => 'Other',
    ];

    public function __construct(SlotTypeRepositoryInterface $slotTypeRepository)
    {
        $this->slotTypeRepository = $slotTypeRepository;
    }

    public function load(ObjectManager $manager): void
    {
        for ($slotTypeNbr = 0; $slotTypeNbr <= 4; $slotTypeNbr++) {
            $slotType = $this->slotTypeRepository->createWith(
                self::TYPES[$slotTypeNbr]
            );
            $manager->persist($slotType);
        }
        $manager->flush();
    }
}
