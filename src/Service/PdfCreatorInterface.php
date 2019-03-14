<?php

declare(strict_types=1);

namespace App\Service;

interface PdfCreatorInterface
{
    public function generatePdf(string $template): string;
}
