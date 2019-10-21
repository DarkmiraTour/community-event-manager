<?php

declare(strict_types=1);

namespace App\Page\Delete;

use App\Action;
use App\Page\PageManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class DeleteAction implements Action
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

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $page = $this->pageManager->find($request->attributes->get('id'));

        $token = new CsrfToken('delete'.$page->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->pageManager->remove($page);
        }

        return new RedirectResponse($this->router->generate('page_index'));
    }
}
