<?php

declare(strict_types=1);

namespace App\Controller\SpecialBenefit;

use App\Repository\SpecialBenefit\SpecialBenefitRepositoryInterface;
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
        SpecialBenefitRepositoryInterface $repository,
        Twig $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(string $id): Response
    {
        $specialBenefit = $this->repository->find($id);
        if (null === $specialBenefit) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('specialBenefit/confirm_delete.html.twig', [
            'specialBenefit' => $specialBenefit,
        ]));
    }
}
