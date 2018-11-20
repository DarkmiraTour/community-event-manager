<?php

declare(strict_types=1);

namespace App\Controller\Page;

use App\Entity\Page;
use App\Repository\Page\PageManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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

    /**
     * @param Page $page
     * @ParamConverter("page", class="App:Page")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(Page $page): Response
    {
        return new Response($this->renderer->render('page/show.html.twig', [
            'page' => $page,
        ]));
    }
}
