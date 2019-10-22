<?php

declare(strict_types=1);

namespace App\Exceptions;

final class InvalidCurrencyException extends \LogicException
{
    public function __construct(string $currency)
    {
        parent::__construct(sprintf('Invalid value: "%s"', $currency));
    }
}
