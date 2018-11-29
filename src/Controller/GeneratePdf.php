<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Page\PageManagerInterface;
use App\Repository\SpecialBenefit\SpecialBenefitManagerInterface;
use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use App\Repository\SponsorshipLevelBenefit\SponsorshipLevelBenefitManagerInterface;
use App\Service\FileUploader;
use App\Service\FormatSponsorshipLevelBenefit;
use App\Service\PdfCreatorInterface;
use Twig\Environment as Twig;

final class GeneratePdf
{
    private $renderer;
    private $pdfCreator;
    private $sponsorshipLevelBenefitManager;
    private $formatSponsorshipLevelBenefit;
    private $sponsorshipLevelManager;
    private $pageManager;
    private $specialBenefitManager;
    private $fileUploader;

    public function __construct(
        Twig $renderer,
        PdfCreatorInterface $pdfCreator,
        SponsorshipLevelBenefitManagerInterface $sponsorshipLevelBenefitManager,
        FormatSponsorshipLevelBenefit $formatSponsorshipLevelBenefit,
        SponsorshipLevelManagerInterface $sponsorshipLevelManager,
        PageManagerInterface $pageManager,
        SpecialBenefitManagerInterface $specialBenefitManager,
        FileUploader $fileUploader
    ) {
        $this->renderer = $renderer;
        $this->pdfCreator = $pdfCreator;
        $this->sponsorshipLevelBenefitManager = $sponsorshipLevelBenefitManager;
        $this->formatSponsorshipLevelBenefit = $formatSponsorshipLevelBenefit;
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
        $this->pageManager = $pageManager;
        $this->specialBenefitManager = $specialBenefitManager;
        $this->fileUploader = $fileUploader;
    }

    public function handle(): string
    {
        $pages = $this->pageManager->findAll();
        foreach ($pages as $page) {
            $this->fileUploader->makeTempFile($page->getBackground());
        }

        $template = $this->renderer->render('pdf/index.html.twig', [
            'pages' => $pages,
            'levels' => $this->sponsorshipLevelManager->getOrderedList(),
            'levelBenefits' => $this->formatSponsorshipLevelBenefit->format(),
            'specialBenefits' => $this->specialBenefitManager->findAll(),
        ]);

        $this->pdfCreator->create('L', 'A4', 'fr', true, 'UTF-8', [10, 15, 10, 15]);

        return $this->pdfCreator->generatePdf($template, 'test');
    }
}
