<?php

declare(strict_types=1);

namespace App\Service;

use Spipu\Html2Pdf\Html2Pdf as Html2Pdf;

final class PdfCreator implements PdfCreatorInterface
{
    /** @var Html2Pdf $pdf */
    private $pdf;

    public function create($orientation = null, $format = null, $lang = null, $unicode = null, $encoding = null, $margin = null): void
    {
        $this->pdf = new Html2Pdf($orientation, $format, $lang, $unicode, $encoding, $margin);
        $this->pdf->setTestIsImage(false);
    }

    /**
     * @param $template
     * @param $name
     *
     * @return string
     *
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     */
    public function generatePdf($template, $name): string
    {
        $this->pdf->writeHTML($template);

        return $this->pdf->Output($name.'.pdf');
    }
}
