<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Repository\Organisation\OrganisationRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment as Twig;
use Knp\Component\Pager\PaginatorInterface;


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
    public function handle(PaginatorInterface $paginator, Request $request)
    {
        $organisations = $paginator->paginate(
            $this->repository->findAllPagination(),
            $request->query->getInt('page',1),
            6
        );
        
        return new Response($this->renderer->render('organisations/list.html.twig', [
            'organisations' => $organisations,
        ]));
    }
}
