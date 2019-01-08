<?php

declare(strict_types=1);

namespace App\Controller\Talk;

use App\Repository\TalkRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class Delete
{
    private $talkRepository;
    private $csrfTokenManager;
    private $router;

    public function __construct(
        TalkRepositoryInterface $talkRepository,
        CsrfTokenManagerInterface $csrfTokenManager,
        RouterInterface $router
    ) {
        $this->talkRepository = $talkRepository;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->router = $router;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $talk = $this->talkRepository->find($id);
        if (!$talk) {
            throw new NotFoundHttpException();
        }

        $token = new CsrfToken("talk-{$talk->getId()}", $request->request->get('_token'));
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new AccessDeniedHttpException();
        }

        $this->talkRepository->remove($talk);

        return new RedirectResponse($this->router->generate('talk_index'));
    }
}
