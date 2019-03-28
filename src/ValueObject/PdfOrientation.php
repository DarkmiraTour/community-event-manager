<?php

declare(strict_types=1);

namespace App\ValueObject;

final class PdfOrientation
{
    private $orientation;

    private const ALLOWED_VALUES = [
        'portrait',
        'landscape',
    ];

    public function __construct(string $orientation)
    {
        if (!in_array($orientation, self::ALLOWED_VALUES)) {
            throw new \DomainException(sprintf('Unknown format value: "%s"', $orientation));
        }
        $this->orientation = $orientation;
    }

    public function getValue(): string
    {
        return $this->orientation;
    }
}
