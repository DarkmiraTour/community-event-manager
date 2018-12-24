<?php

declare(strict_types=1);

namespace App\Controller\Space;

use App\Repository\Schedule\SpaceRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class Delete
{
    private $router;
    private $csrfTokenManager;
    private $spaceRepository;

    public function __construct(
        SpaceRepositoryInterface $spaceRepository,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->spaceRepository = $spaceRepository;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request, string $id): RedirectResponse
    {
        $space = $this->spaceRepository->find($id);

        if (!$space) {
            throw new NotFoundHttpException();
        }

        $token = new CsrfToken('delete'.$id, $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->spaceRepository->remove($space);
        }

        return new RedirectResponse($this->router->generate('schedule_index'));
    }
}
