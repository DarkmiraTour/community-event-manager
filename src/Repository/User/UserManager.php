<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Entity\User;
use App\ValueObject\Username;
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
        $this->userRepository->save($user);

        return $user;
    }

    public function updateUserInformation(User $user, string $emailAddress = null, Username $username = null): void
    {
        $this->userRepository->updateUserInformation($user, $emailAddress, $username);
    }

    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }
}
