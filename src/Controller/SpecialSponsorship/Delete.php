<?php

declare(strict_types=1);

namespace App\Controller\SpecialSponsorship;

use App\Repository\SpecialSponsorship\SpecialSponsorshipManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class Delete
{
    private $specialSponsorshipManager;
    private $router;
    private $csrfTokenManager;

    public function __construct(
        SpecialSponsorshipManagerInterface $specialSponsorshipManager,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    )
    {
        $this->specialSponsorshipManager = $specialSponsorshipManager;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function handle(Request $request, string $id): RedirectResponse
    {
        $specialSponsorship = $this->specialSponsorshipManager->find($id);

        if (null === $specialSponsorship) {
            throw new NotFoundHttpException();
        }

        $token = new CsrfToken('delete' . $id, $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->specialSponsorshipManager->remove($specialSponsorship);
        }

        return new RedirectResponse($this->router->generate('special_sponsorship_index'));
    }
}
