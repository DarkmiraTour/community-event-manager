<?php

declare(strict_types=1);

namespace App\Organisation\Index;

use App\Action;
use App\Organisation\Config\Organisation;
use App\Organisation\OrganisationRepositoryInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class IndexAction implements Action
{
    private $renderer;
    private $repository;
    private $config;
    private $pagination;

    public function __construct(
        Twig $renderer,
        OrganisationRepositoryInterface $repository,
        Organisation $config,
        PaginatorInterface $pagination
    ) {
        $this->renderer = $renderer;
        $this->repository = $repository;
        $this->config = $config;
        $this->pagination = $pagination;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(Request $request): Response
    {
        $pagination = $this->pagination->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1),
            $this->config->getMaxListOrganisationEntries()
        );

        return new Response($this->renderer->render('organisations/list.html.twig', [
            'pagination' => $pagination,
        ]));
    }
}
