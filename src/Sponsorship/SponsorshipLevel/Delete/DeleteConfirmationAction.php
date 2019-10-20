<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevel\Delete;

use App\Action;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class DeleteConfirmationAction implements Action
{
    private $repository;
    private $renderer;

    public function __construct(
        SponsorshipLevelRepositoryInterface $repository,
        Twig $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(Request $request): Response
    {
        $sponsorshipLevel = $this->repository->find($request->attributes->get('id'));
        if (null === $sponsorshipLevel) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('sponsorshipLevel/confirm_delete.html.twig', [
            'sponsorshipLevel' => $sponsorshipLevel,
        ]));
    }
}
