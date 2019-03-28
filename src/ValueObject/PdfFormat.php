<?php

declare(strict_types=1);

namespace App\ValueObject;

final class PdfFormat
{
    private $format;

    private const ALLOWED_VALUES = [
        'letter',
        'legal',
        'A4',
    ];

    public function __construct(string $format)
    {
        if (!in_array($format, self::ALLOWED_VALUES)) {
            throw new \DomainException(sprintf('Unknown format value: "%s"', $format));
        }

        $this->format = $format;
    }

    public function getValue(): string
    {
        return $this->format;
    }
}
