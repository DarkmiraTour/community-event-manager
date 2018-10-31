<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Repository\OrganisationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

final class Show
{
    private $renderer;
    private $repository;

    public function __construct(Twig $renderer, OrganisationRepository $repository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    public function handle(int $id): Response
    {
        $organisation = $this->repository->find($id);

        if (null === $organisation) {
            throw new NotFoundHttpException();
        }

        return new Response(
            $this->renderer->render('organisations/show.html.twig', ['organisation' => $organisation])
        );
    }
}
