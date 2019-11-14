<?php

declare(strict_types=1);

namespace App\Controller\Space;

use App\Dto\SpaceRequest;
use App\Exceptions\NoEventSelectedException;
use App\Form\SpaceType;
use App\Repository\Schedule\SpaceRepositoryInterface;
use App\Schedule\ScheduleRepositoryInterface;
use App\Service\Event\EventServiceInterface;
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
    private $scheduleRepository;
    private $eventService;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        SpaceRepositoryInterface $repository,
        ScheduleRepositoryInterface $scheduleRepository,
        EventServiceInterface $eventService
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->repository = $repository;
        $this->scheduleRepository = $scheduleRepository;
        $this->eventService = $eventService;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        if (!$this->eventService->isEventSelected()) {
            throw new NoEventSelectedException();
        }

        $spaceRequest = new SpaceRequest();

        $form = $this->formFactory->create(SpaceType::class, $spaceRequest);
        $form->handleRequest($request);

        $space = $this->repository->createFrom($spaceRequest);

        $this->repository->save($space);

        return new RedirectResponse($this->router->generate('schedule_index'));
    }
}
