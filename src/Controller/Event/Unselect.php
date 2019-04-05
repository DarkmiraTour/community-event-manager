<?php

declare(strict_types=1);

namespace App\Controller\Event;

use App\Service\Event\EventServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\SessionUnavailableException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_USER')")
 */
final class Unselect
{
    private $router;
    private $eventService;

    public function __construct(RouterInterface $renderer, EventServiceInterface $eventService)
    {
        $this->router = $renderer;
        $this->eventService = $eventService;
    }

    public function handle(): Response
    {
        if (!$this->eventService->isUserLoggedIn()) {
            throw new SessionUnavailableException('The user is not logged in');
        }

        $this->eventService->unselectEvent();

        return new RedirectResponse($this->router->generate('index'));
    }
}
