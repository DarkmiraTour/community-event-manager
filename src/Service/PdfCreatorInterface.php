<?php

declare(strict_types=1);

namespace App\Service;

interface PdfCreatorInterface
{
    public function create($orientation = null, $format = null, $lang = null, $unicode = null, $encoding = null, $margin = null): void;

    public function generatePdf($template, $name): string;
}
