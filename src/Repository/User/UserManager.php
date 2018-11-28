<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Entity\User;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserManager implements UserManagerInterface
{
    private $userRepository;
    private $passwordEncoder;

    public function __construct(UserRepositoryInterface $userRepository, UserPasswordEncoderInterface $encodedPassword)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $encodedPassword;
    }

    public function find(string $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function findOneBy(array $criteria): ?User
    {
        return $this->userRepository->findOneBy($criteria);
    }

    public function save(User $user): void
    {
        $this->userRepository->save($user);
    }

    public function remove(User $user): void
    {
        $this->userRepository->remove($user);
    }

    public function create(string $email, string $username, string $plainPassword): User
    {
        $user = $this->userRepository->createWith($email, $username);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $plainPassword));

        return $user;
    }
}
