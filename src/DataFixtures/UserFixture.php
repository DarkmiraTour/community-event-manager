<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\User\UserManagerInterface;

class UserFixture extends Fixture
{
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userManager->create(
            'user@test.com',
            'usertest',
            'userpass'
        );

        $admin = $this->userManager->create(
            'admin@test.com',
            'admintest',
            'adminpass'
        );
        $admin->upgradeToAdmin();

        $manager->persist($user);
        $manager->persist($admin);
        $manager->flush();
    }
}
