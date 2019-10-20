<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Page\PageManagerInterface;
use App\Sponsorship\SpecialBenefit\SpecialBenefitManagerInterface;
use App\Service\Event\EventServiceInterface;
use App\Service\PdfCreatorInterface;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelManagerInterface;
use App\Sponsorship\SponsorshipLevelBenefit\FormatSponsorshipLevelBenefit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class GeneratePdf
{
    private $renderer;
    private $pdfCreator;
    private $formatSponsorshipLevelBenefit;
    private $sponsorshipLevelManager;
    private $pageManager;
    private $specialBenefitManager;
    private $eventService;

    public function __construct(
        Twig $renderer,
        PdfCreatorInterface $pdfCreator,
        FormatSponsorshipLevelBenefit $formatSponsorshipLevelBenefit,
        SponsorshipLevelManagerInterface $sponsorshipLevelManager,
        PageManagerInterface $pageManager,
        SpecialBenefitManagerInterface $specialBenefitManager,
        EventServiceInterface $eventService
    ) {
        $this->renderer = $renderer;
        $this->pdfCreator = $pdfCreator;
        $this->formatSponsorshipLevelBenefit = $formatSponsorshipLevelBenefit;
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
        $this->pageManager = $pageManager;
        $this->specialBenefitManager = $specialBenefitManager;
        $this->eventService = $eventService;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(): Response
    {
        $pages = $this->pageManager->findAll();

        $template = $this->renderer->render('pdf/index.html.twig', [
            'pages' => $pages,
            'levels' => $this->sponsorshipLevelManager->getOrderedList(),
            'levelBenefits' => $this->formatSponsorshipLevelBenefit->format(),
            'specialBenefits' => $this->specialBenefitManager->findAll(),
        ]);

        $pdf = $this->pdfCreator->generatePdf($template);
        $dateAtom = (new \DateTime())->format(\DateTime::ATOM);
        $eventName = $this->eventService->getSelectedEventName();

        return new Response(
            $pdf,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="%s-%s.pdf"', $eventName, $dateAtom),
            ]
        );
    }
}
