<?php

declare(strict_types=1);

namespace App\Controller\Page;

use App\Repository\Page\PageManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class Delete
{
    private $pageManager;
    private $router;
    private $csrfTokenManager;

    public function __construct(
        PageManagerInterface $pageManager,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->pageManager = $pageManager;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function handle(Request $request): RedirectResponse
    {
        $page = $this->pageManager->find($request->attributes->get('id'));

        $token = new CsrfToken('delete'.$page->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->pageManager->remove($page);
        }

        return new RedirectResponse($this->router->generate('page_index'));
    }
}
