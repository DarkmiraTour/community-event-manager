<?php

declare(strict_types=1);

namespace App\Controller\Space;

use App\Dto\SpaceRequest;
use App\Form\SpaceType;
use App\Repository\Schedule\SpaceRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $router;
    private $renderer;
    private $formFactory;
    private $repository;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        SpaceRepositoryInterface $repository
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->repository = $repository;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $spaceRequest = new SpaceRequest();

        $form = $this->formFactory->create(SpaceType::class, $spaceRequest);
        $form->handleRequest($request);

        $space = $this->repository->createFrom($spaceRequest);

        $this->repository->save($space);

        return new RedirectResponse($this->router->generate('schedule_index'));
    }
}
