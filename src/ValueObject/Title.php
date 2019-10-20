<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exceptions\ValueObject\Title\UnableToCreateTitleException;

final class Title
{
    public const MIN_LENGTH = 5;
    public const MAX_LENGTH = 50;

    private $title;

    public function __construct(string $title)
    {
        if (self::MIN_LENGTH >= strlen($title) && self::MAX_LENGTH <= strlen($title)) {
            throw new UnableToCreateTitleException(sprintf('Title length is %d and does not match the requested range from %d to %d.', strlen($title), self::MIN_LENGTH, self::MAX_LENGTH));
        }
        $this->title = $title;
    }

    public function __toString()
    {
        return $this->title;
    }
}
