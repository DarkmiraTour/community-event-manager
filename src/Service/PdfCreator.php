<?php

declare(strict_types=1);

namespace App\Service;

use Spipu\Html2Pdf\Html2Pdf;

final class PdfCreator implements PdfCreatorInterface
{
    /** @var Html2Pdf $pdf */
    private $pdf;

    public function create(string $orientation = null, string $format = null, string $lang = null, bool $unicode = null, string $encoding = null, array $margin = null): void
    {
        $this->pdf = new Html2Pdf($orientation, $format, $lang, $unicode, $encoding, $margin);
        $this->pdf->setTestIsImage(false);
    }

    public function generatePdf(string $template, string $name): string
    {
        $this->pdf->writeHTML($template);

        return $this->pdf->Output($name.'.pdf');
    }
}
