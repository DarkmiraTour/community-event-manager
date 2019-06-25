<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Event\EventRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Home
{
    private $renderer;
    private $eventRepository;

    public function __construct(Twig $renderer, EventRepository $eventRepository)
    {
        $this->renderer = $renderer;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(): Response
    {
        $eventList = $this->eventRepository->findAll();

        return new Response($this->renderer->render('home.html.twig', ['events' => $eventList]));
    }
}
