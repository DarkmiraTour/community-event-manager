<?php

declare(strict_types=1);

namespace App\Controller\Event;

use App\Repository\Event\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $repository;

    public function __construct(Twig $renderer, EventRepository $repository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    public function handle(): Response
    {
        $eventList = $this->repository->findAll();

        return new Response($this->renderer->render('home.html.twig', ['events' => $eventList]));
    }
}
