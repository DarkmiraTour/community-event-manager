<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipBenefit;

use App\Repository\SponsorshipBenefit\SponsorshipBenefitRepositoryInterface;
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
        SponsorshipBenefitRepositoryInterface $repository,
        Twig $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(string $id): Response
    {
        $sponsorshipBenefit = $this->repository->find($id);
        if (null === $sponsorshipBenefit) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('sponsorshipBenefit/confirm_delete.html.twig', [
            'sponsorshipBenefit' => $sponsorshipBenefit,
        ]));
    }
}
