<?php

declare(strict_types=1);

namespace App\Page\Show;

use App\Action;
use App\Page\PageManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class ShowAction implements Action
{
    private $renderer;
    private $pageManager;

    public function __construct(Twig $renderer, PageManagerInterface $pageManager)
    {
        $this->renderer = $renderer;
        $this->pageManager = $pageManager;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(Request $request): Response
    {
        $page = $this->pageManager->find($request->attributes->get('id'));

        return new Response($this->renderer->render('page/show.html.twig', [
            'page' => $page,
        ]));
    }
}
