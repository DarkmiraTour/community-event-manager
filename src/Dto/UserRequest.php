<?php

declare(strict_types=1);

namespace App\Dto;

final class UserRequest
{
    public $email;
    public $username;
    public $plainPassword;

    public function __construct(string $email = null, string $username = null, string $plainPassword = null)
    {
        $this->email = $email;
        $this->username = $username;
        $this->plainPassword = $plainPassword;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
}
