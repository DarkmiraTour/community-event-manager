<?php

declare(strict_types=1);

namespace App\Controller\Event;

use App\Dto\EventRequest;
use App\Form\EventType;
use App\Repository\Event\EventRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class Create
{
    private $renderer;
    private $formFactory;
    private $eventRepository;
    private $router;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        EventRepository $eventRepository,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->eventRepository = $eventRepository;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $eventRequest = new EventRequest();
        $form = $this->formFactory->create(EventType::class, $eventRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $this->eventRepository->createFromRequest($eventRequest);
            $this->eventRepository->save($event);

            return new RedirectResponse($this->router->generate('index'));
        }

        return new Response($this->renderer->render(
            'event/create.html.twig', [
                'form' => $form->createView(),
            ])
        );
    }
}
