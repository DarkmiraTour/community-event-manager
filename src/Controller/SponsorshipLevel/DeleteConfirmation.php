<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipLevel;

use App\Repository\SponsorshipLevel\SponsorshipLevelRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class DeleteConfirmation
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

    public function handle(string $id): Response
    {
        $sponsorshipLevel = $this->repository->find($id);
        if (null === $sponsorshipLevel) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('sponsorshipLevel/confirm_delete.html.twig', [
            'sponsorshipLevel' => $sponsorshipLevel,
        ]));
    }
}
