<?php

declare(strict_types=1);

namespace App\Controller\Schedule;

use App\Dto\ScheduleRequest;
use App\Exceptions\NoEventSelectedException;
use App\Form\ScheduleType;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use App\Service\Event\EventServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $router;
    private $renderer;
    private $formFactory;
    private $repository;
    private $flashBag;
    private $eventService;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        ScheduleRepositoryInterface $repository,
        FlashBagInterface $flashBag,
        EventServiceInterface $eventService
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->repository = $repository;
        $this->flashBag = $flashBag;
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

        $scheduleRequest = new ScheduleRequest();

        $form = $this->formFactory->create(ScheduleType::class, $scheduleRequest);
        $form->handleRequest($request);

        $schedule = $this->repository->createFrom(
            $this->eventService->getSelectedEvent(),
            $scheduleRequest
        );

        $scheduleExists = $this->repository->findBy(['day' => $schedule->getDay()]);

        if ($scheduleExists) {
            $this->flashBag->add('error', 'This day alreadys exists');

            return new RedirectResponse($this->router->generate('schedule_index'));
        }

        $this->repository->save($schedule);

        return new RedirectResponse($this->router->generate('schedule_index'));
    }
}
