<?php

declare(strict_types=1);

namespace App\Controller\Page;

use App\Repository\Page\PageManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Show
{
    private $renderer;
    private $pageManager;

    public function __construct(Twig $renderer, PageManagerInterface $pageManager)
    {
        $this->renderer = $renderer;
        $this->pageManager = $pageManager;
    }

    public function handle(Request $request): Response
    {
        $page = $this->pageManager->find($request->attributes->get('id'));

        return new Response($this->renderer->render('page/show.html.twig', [
            'page' => $page,
        ]));
    }
}
