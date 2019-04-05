<?php

declare(strict_types=1);

namespace App\Controller\Event;

use App\Repository\Event\EventRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Twig\Environment as Twig;

final class Delete
{
    private $renderer;
    private $repository;
    private $csrfTokenManager;
    private $router;

    public function __construct(
        Twig $renderer,
        EventRepositoryInterface $repository,
        CsrfTokenManagerInterface $csrfTokenManager,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->repository = $repository;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->router = $router;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        if (null === ($event = $this->repository->findById($id))) {
            throw new NotFoundHttpException(sprintf('The event could not be found this this id %s', $id));
        }

        $token = new CsrfToken('delete'.$event->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->repository->remove($event);
        }

        return new RedirectResponse($this->router->generate('index'));
    }
}
