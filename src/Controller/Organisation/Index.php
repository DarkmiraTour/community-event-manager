<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Repository\Organisation\OrganisationRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
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
    public function handle()
    {
        $organisations = $this->repository->findAll();

        return new Response($this->renderer->render('organisations/list.html.twig', [
            'organisations' => $organisations,
        ]));
    }
}
