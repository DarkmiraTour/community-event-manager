<?php

declare(strict_types=1);

namespace App\Service;

interface PdfCreatorInterface
{
    public function create(string $orientation = null, string $format = null, string $lang = null, bool $unicode = null, string $encoding = null, array $margin = null): void;

    public function generatePdf(string $template, string $name): string;
}
