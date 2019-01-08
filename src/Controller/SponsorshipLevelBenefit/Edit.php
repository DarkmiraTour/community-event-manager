<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipLevelBenefit;

use App\Dto\SponsorshipLevelBenefitRequest;
use App\Entity\SponsorshipBenefit;
use App\Entity\SponsorshipLevel;
use App\Entity\SponsorshipLevelBenefit;
use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use App\Repository\SponsorshipLevelBenefit\SponsorshipLevelBenefitManagerInterface;
use App\Service\FormatSponsorshipLevelBenefit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Twig\Environment as Twig;

final class Edit
{
    private $renderer;
    private $sponsorshipLevelBenefitManager;
    private $csrfTokenManager;

    public function __construct(
        Twig $renderer,
        SponsorshipLevelBenefitManagerInterface $sponsorshipLevelBenefitManager,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->renderer = $renderer;
        $this->sponsorshipLevelBenefitManager = $sponsorshipLevelBenefitManager;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(FormatSponsorshipLevelBenefit $formatSponsorshipLevelBenefit, SponsorshipLevelManagerInterface $sponsorshipLevelManager): Response
    {
        return new Response($this->renderer->render('sponsorshipLevelBenefit/edit.html.twig', [
            'levels' => $sponsorshipLevelManager->getOrderedList(),
            'levelBenefits' => $formatSponsorshipLevelBenefit->format(),
        ]));
    }

    public function editSponsorshipLevelPosition(Request $request, SponsorshipLevelManagerInterface $sponsorshipLevelManager): JsonResponse
    {
        $token = new CsrfToken('sponsorship-level-benefit', $request->request->get('_token'));
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            return new JsonResponse([false]);
        }

        $move = $request->request->get('move');
        $id = $request->request->get('id');

        $new_level = $sponsorshipLevelManager->switchPosition($move, $id);

        return new JsonResponse([
            'new_level_id' => $new_level->getId(),
        ]);
    }

    public function editSponsorshipBenefitPosition(Request $request, SponsorshipBenefitManagerInterface $sponsorshipBenefitManager): JsonResponse
    {
        $token = new CsrfToken('sponsorship-level-benefit', $request->request->get('_token'));
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            return new JsonResponse([false]);
        }

        $move = $request->request->get('move');
        $id = $request->request->get('id');

        $new_benefit = $sponsorshipBenefitManager->switchPosition($move, $id);

        return new JsonResponse([
            'new_benefit_id' => $new_benefit->getId(),
        ]);
    }

    public function editDatas(Request $request, SponsorshipBenefitManagerInterface $sponsorshipBenefitManager, SponsorshipLevelManagerInterface $sponsorshipLevelManager): JsonResponse
    {
        $token = new CsrfToken('sponsorship-level-benefit', $request->request->get('_token'));
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            return new JsonResponse([false]);
        }

        $checked = $request->request->get('is_checked') !== 'false' ? true : false;
        $content = $request->request->get('text', null) ? $request->request->get('text') : null;

        $sponsorshipBenefit = $sponsorshipBenefitManager->find($request->request->get('benefit_id'));
        $sponsorshipLevel = $sponsorshipLevelManager->find($request->request->get('level_id'));

        $sponsorshipLevelBenefit = $this->sponsorshipLevelBenefitManager->getByBenefitAndLevel($sponsorshipBenefit, $sponsorshipLevel);
        if ($sponsorshipLevelBenefit) {
            return new JsonResponse($this->editSponsorshipLevelBenefit($checked, $sponsorshipLevelBenefit, $content));
        }
        if ($checked) {
            return new JsonResponse($this->addSponsorshipLevelBenefit($sponsorshipLevel, $sponsorshipBenefit, $content));
        }

        return new JsonResponse([false]);
    }

    private function editSponsorshipLevelBenefit(bool $checked, SponsorshipLevelBenefit $sponsorshipLevelBenefit, ?string $content): array
    {
        $sponsorshipLevelBenefitRequest = SponsorshipLevelBenefitRequest::createFromEntity($sponsorshipLevelBenefit);
        if ($checked) {
            $sponsorshipLevelBenefitRequest->content = $content;
            $sponsorshipLevelBenefitRequest->updateEntity($sponsorshipLevelBenefit);
            $this->sponsorshipLevelBenefitManager->save($sponsorshipLevelBenefit);

            return [true];
        }
        $this->sponsorshipLevelBenefitManager->remove($sponsorshipLevelBenefit);

        return [true];
    }

    private function addSponsorshipLevelBenefit(SponsorshipLevel $sponsorshipLevel, SponsorshipBenefit $sponsorshipBenefit, ?string $content): array
    {
        $sponsorshipLevelBenefitRequest = new SponsorshipLevelBenefitRequest(
            $sponsorshipLevel,
            $sponsorshipBenefit,
            $content
        );
        $sponsorshipLevel = $this->sponsorshipLevelBenefitManager->createFrom($sponsorshipLevelBenefitRequest);
        $this->sponsorshipLevelBenefitManager->save($sponsorshipLevel);

        return [true];
    }
}
