<?php

declare(strict_types=1);

namespace App\Controller\Page;

use App\Repository\Page\PageRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class DeleteConfirmation
{
    private $repository;
    private $renderer;

    public function __construct(
        PageRepositoryInterface $repository,
        Twig $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(string $id): Response
    {
        $page = $this->repository->find($id);
        if (null === $page) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('page/confirm_delete.html.twig', [
            'page' => $page,
        ]));
    }
}
