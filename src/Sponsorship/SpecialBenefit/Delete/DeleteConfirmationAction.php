<?php

declare(strict_types=1);

namespace App\Sponsorship\SpecialBenefit\Delete;

use App\Action;
use App\Sponsorship\SpecialBenefit\SpecialBenefitRepositoryInterface;
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
        SpecialBenefitRepositoryInterface $repository,
        Twig $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(Request $request): Response
    {
        $specialBenefit = $this->repository->find($request->attributes->get('id'));
        if (null === $specialBenefit) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('specialBenefit/confirm_delete.html.twig', [
            'specialBenefit' => $specialBenefit,
        ]));
    }
}
