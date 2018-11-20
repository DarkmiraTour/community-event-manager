<?php

declare(strict_types=1);

namespace App\Controller\Page;

use App\Repository\Page\PageManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment As Twig;

final class Index
{
    private $renderer;
    private $pageManager;

    public function __construct(
        Twig $renderer,
        PageManagerInterface $pageManager
    )
    {
        $this->renderer = $renderer;
        $this->pageManager = $pageManager;
    }

    /**
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(): Response
    {
        return new Response($this->renderer->render('page/index.html.twig', [
            'pages' => $this->pageManager->findAll(),
        ]));
    }
}
