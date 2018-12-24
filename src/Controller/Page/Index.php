<?php

declare(strict_types=1);

namespace App\Controller\Page;

use App\Repository\Page\PageManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $pageManager;

    public function __construct(
        Twig $renderer,
        PageManagerInterface $pageManager
    ) {
        $this->renderer = $renderer;
        $this->pageManager = $pageManager;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(): Response
    {
        return new Response($this->renderer->render('page/index.html.twig', [
            'pages' => $this->pageManager->findAll(),
        ]));
    }
}
