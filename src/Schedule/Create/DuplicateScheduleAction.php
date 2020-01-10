<?php

declare(strict_types=1);

namespace App\Schedule\Create;

use App\Schedule\ScheduleRepositoryInterface;
use App\Service\Event\EventServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class DuplicateScheduleAction
{
    private $router;
    private $repository;
    private $renderer;
    private $formFactory;
    private $flashBag;
    private $eventService;

    public function __construct(
        RouterInterface $router,
        ScheduleRepositoryInterface $repository,
        FormFactoryInterface $formFactory,
        Twig $renderer,
        FlashBagInterface $flashBag,
        EventServiceInterface $eventService
    ) {
        $this->router = $router;
        $this->repository = $repository;
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->flashBag = $flashBag;
        $this->eventService = $eventService;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        if (null === ($schedule = $this->repository->find($request->attributes->get('id')))) {
            throw new NotFoundHttpException();
        }
        $scheduleRequest = new CreateScheduleRequest();

        $form = $this->formFactory->create(CreateScheduleFormType::class, $scheduleRequest);
        $form->handleRequest($request);

        $scheduleExists = $this->repository->findBy(['day' => $scheduleRequest->day]);

        if ($scheduleExists) {
            $this->flashBag->add('error', 'This day alreadys exists');
        }

        if ($form->isSubmitted() && $form->isValid() && !$scheduleExists) {
            $schedule->setDay($scheduleRequest->day);

            $this->repository->duplicate($schedule);

            return new RedirectResponse($this->router->generate('schedule_index'));
        }

        return new Response($this->renderer->render('schedule/configure/confirm_duplicate_day.html.twig', [
            'schedule' => $schedule,
            'form' => $form->createView(),
            'event' => $this->eventService->getSelectedEvent(),
        ]));
    }
}
