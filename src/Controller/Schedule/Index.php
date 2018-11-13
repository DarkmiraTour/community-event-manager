<?php

declare(strict_types=1);

namespace App\Controller\Schedule;

use App\Dto\SpaceRequest;
use App\Form\SpaceType;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $repository;
    private $formFactory;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        ScheduleRepositoryInterface $repository
    )
    {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->repository = $repository;
    }

    public function handle(Request $request): Response
    {
        $schedules = $this->repository->findAll();

        $spaceRequest = new SpaceRequest();

        $form = $this->formFactory->create(SpaceType::class, $spaceRequest);
        $form->handleRequest($request);

        return new Response($this->renderer->render('schedule/index.html.twig', [
            'schedules' => $schedules,
            'formSpace' => $form->createView(),
        ]));
    }
}