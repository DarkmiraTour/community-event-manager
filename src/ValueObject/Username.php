<?php

declare(strict_types=1);

namespace App\ValueObject;

use Symfony\Component\Validator\Constraints;

final class Username
{
    private const CONSTRAINT = 'The username must be maximum 50 characters long.';

    /**
     * @Constraints\NotBlank()
     * @Constraints\Length(
     *     max="50",
     *     maxMessage="The username must be maximum 50 characters long."
     * )
     */
    private $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    public static function getCreationConstraint(): string
    {
        return self::CONSTRAINT;
    }
}
