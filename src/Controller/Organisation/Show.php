<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Repository\Organisation\OrganisationRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

final class Show
{
    private $renderer;
    private $repository;

    public function __construct(Twig $renderer, OrganisationRepositoryInterface $repository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(string $id): Response
    {
        $organisation = $this->repository->find($id);

        if (null === $organisation) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('organisations/show.html.twig', [
            'organisation' => $organisation,
        ]));
    }
}
