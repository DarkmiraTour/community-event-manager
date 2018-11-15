<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Repository\Organisation\OrganisationRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
final class Delete
{
    private $repository;
    private $router;
    private $csrfManager;

    public function __construct(
        OrganisationRepositoryInterface $repository,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfManager
    ) {
        $this->repository = $repository;
        $this->router = $router;
        $this->csrfManager = $csrfManager;
    }

    public function handle(Request $request, string $id): Response
    {
        $organisation = $this->repository->find($id);
        if (null === $organisation) {
            throw new NotFoundHttpException();
        }

        $token = new CsrfToken("organisation-{$organisation->getId()}", $request->request->get('_token'));
        if (!$this->csrfManager->isTokenValid($token)) {
            throw  new AccessDeniedHttpException();
        }

        $this->repository->remove($organisation);

        return new RedirectResponse($this->router->generate('organisation_list'));
    }
}
