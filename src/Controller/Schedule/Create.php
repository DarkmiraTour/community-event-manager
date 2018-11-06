<?php

declare(strict_types=1);

namespace App\Controller\Schedule;

use App\Dto\ScheduleRequest;
use App\Form\ScheduleType;
use App\Repository\Schedule\ScheduleRepositoryInterface;
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
        ScheduleRepositoryInterface $repository
    )
    {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->repository = $repository;
    }

    public function handle(Request $request): Response
    {
        $scheduleRequest = new ScheduleRequest();

        $form = $this->formFactory->create(ScheduleType::class, $scheduleRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $schedule = $this->repository->createFrom($scheduleRequest);

            $this->repository->save($schedule);

            return new RedirectResponse($this->router->generate('schedule_index'));
        }

        return new Response($this->renderer->render('schedule/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}