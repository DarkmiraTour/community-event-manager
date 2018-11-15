<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Repository\User\UserRepositoryInterface;

class UserFixture extends Fixture
{
    private $encodedPassword;
    private $userRepository;

    public function __construct(UserPasswordEncoderInterface $encodedPassword, UserRepositoryInterface $userRepository)
    {
        $this->encodedPassword = $encodedPassword;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User(
            $this->userRepository->nextIdentity(),
            'user@test.com',
            'usertest'
        );

        $user->setPassword($this->encodedPassword->encodePassword($user, 'userpass'));
        $manager->persist($user);

        $admin = new User(
            $this->userRepository->nextIdentity(),
            'admin@test.com',
            'admintest'
        );

        $admin->upgradeToAdmin();
        $admin->setPassword($this->encodedPassword->encodePassword($admin, 'adminpass'));

        $manager->persist($admin);
        $manager->flush();
    }
}
