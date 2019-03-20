<?php

declare(strict_types=1);

namespace App\Controller\SpaceType;

use App\Repository\Schedule\SpaceTypeRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class Delete
{
    private $router;
    private $csrfTokenManager;
    private $spaceTypeRepository;
    private $flashBag;

    public function __construct(
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager,
        SpaceTypeRepositoryInterface $spaceTypeRepository,
        FlashBagInterface $flashBag
    ) {
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->spaceTypeRepository = $spaceTypeRepository;
        $this->flashBag = $flashBag;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $spaceType = $this->spaceTypeRepository->find($id);
        if ($spaceType->getSpaces()->count() > 0) {
            $this->flashBag->add(
                'error',
                sprintf('%s is currently used in schedule and cannot be deleted', $spaceType->getName())
            );

            return new RedirectResponse($this->router->generate('schedule_space_type_index'));
        }

        if (!$spaceType) {
            throw new NotFoundHttpException();
        }

        $token = new CsrfToken("space-type-{$spaceType->getId()}", $request->request->get('_token'));
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new AccessDeniedHttpException();
        }

        $this->spaceTypeRepository->remove($spaceType);

        return new RedirectResponse($this->router->generate('schedule_space_type_index'));
    }
}
