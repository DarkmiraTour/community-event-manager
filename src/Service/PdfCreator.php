<?php

declare(strict_types=1);

namespace App\Service;

use Spipu\Html2Pdf\Html2Pdf;

final class PdfCreator implements PdfCreatorInterface
{
    private $pdf;
    private $orientation;
    private $format;
    private $lang;
    private $unicode;
    private $encoding;
    private $margin;

    public function __construct(string $orientation, string $format, string $lang, bool $unicode, string $encoding, array $margin)
    {
        $this->orientation = $orientation;
        $this->format = $format;
        $this->lang = $lang;
        $this->unicode = $unicode;
        $this->encoding = $encoding;
        $this->margin = $margin;
    }

    public function create(): void
    {
        $this->pdf = new Html2Pdf($this->orientation, $this->format, $this->lang, $this->unicode, $this->encoding, $this->margin);
        $this->pdf->setTestIsImage(false);
    }

    public function generatePdf(string $template, string $name): string
    {
        $this->pdf->writeHTML($template);

        return $this->pdf->Output($name.'.pdf');
    }
}
