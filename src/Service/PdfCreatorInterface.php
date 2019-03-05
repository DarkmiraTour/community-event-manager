<?php

declare(strict_types=1);

namespace App\Service;

interface PdfCreatorInterface
{
    public function create(): void;

    public function generatePdf(string $template, string $name): string;
}
