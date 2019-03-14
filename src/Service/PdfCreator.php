<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObject\PdfFormat;
use App\ValueObject\PdfOrientation;
use Dompdf\Dompdf;

final class PdfCreator implements PdfCreatorInterface
{
    private $orientation;
    private $format;
    private $pdf;

    public function __construct(
        PdfOrientation $orientation,
        PdfFormat $format,
        array $pdfOptions
    ) {
        $this->orientation = $orientation;
        $this->format = $format;
        $this->pdf = new Dompdf($pdfOptions);
    }

    public function generatePdf(string $template): string
    {
        $this->pdf->setPaper($this->format->getValue(), $this->orientation->getValue());
        $this->pdf->loadHtml($template);
        $this->pdf->render();

        return $this->pdf->output();
    }
}
