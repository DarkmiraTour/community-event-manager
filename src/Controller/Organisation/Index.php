<?php

declare(strict_types=1);

namespace App\Controller\Organisation;


use App\Repository\OrganisationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class Index
{
    private $renderer;
    private $repository;

    public function __construct(\Twig_Environment $renderer, OrganisationRepository $repository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    public function handle()
    {
        $organisations = $this->repository->findAll();

        return new Response(
            $this->renderer->render('organisations/list.html.twig', ['organisations' => $organisations])
        );
    }
}
