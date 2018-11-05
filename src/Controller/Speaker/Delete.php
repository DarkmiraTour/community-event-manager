<?php declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Repository\SpeakerRepositoryInterface;
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
    private $speakerRepository;
    private $csrfTokenManager;
    private $router;

    public function __construct(
        Twig $renderer,
        SpeakerRepositoryInterface $speakerRepository,
        CsrfTokenManagerInterface $csrfTokenManager,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $speaker = $this->speakerRepository->find($request->attributes->get('id'));
        if (!$speaker) {
            throw new NotFoundHttpException();
        }

        $token = new CsrfToken('delete' . $speaker->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->speakerRepository->remove($speaker);
        }

        return new RedirectResponse($this->router->generate('speaker_index'));
    }
}
