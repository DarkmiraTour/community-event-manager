<?php

declare(strict_types=1);

namespace App\User;

use App\User\Username\Username;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    private $id;
    private $email;
    private $username;
    private $roles = [];
    private $password;

    public function __construct(
        UuidInterface $id,
        string $email,
        Username $username
    ) {
        $this->id = $id->toString();
        $this->email = $email;
        $this->username = $username->__toString();
        $this->roles = [self::ROLE_USER];
    }

    public function upgradeToAdmin(): self
    {
        $roles[] = self::ROLE_ADMIN;

        $this->roles = array_unique($roles);

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = self::ROLE_USER;

        return array_unique($roles);
    }

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): ?string
    {
        // the salt can be set here to add security with Argon2i algorithm
        return null;
    }

    public function eraseCredentials(): void
    {
        //as the plaintext password is not stored into this object, there is no sensitive data to remove, this function is still called by Symfony Authentication Guard
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmailAddress(): string
    {
        return $this->email;
    }

    public function updateEmailAddress(string $emailAddress): void
    {
        if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            $this->email = $emailAddress;
        }
    }

    public function updateUsername(Username $username): void
    {
        $this->username = $username->__toString();
    }

    public function toArray(): array
    {
        return [
            $this->getEmailAddress(),
            $this->getUsername(),
            implode('|', $this->getRoles()),
        ];
    }
}
