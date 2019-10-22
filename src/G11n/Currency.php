<?php

declare(strict_types=1);

namespace App\G11n;

use App\Exceptions\InvalidCurrencyException;

final class Currency
{
    private $value;

    public function __construct(string $currency, array $currencyAuthorized)
    {
        if (!in_array($currency, $currencyAuthorized)) {
            throw new InvalidCurrencyException($currency);
        }
        $this->value = $currency;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
