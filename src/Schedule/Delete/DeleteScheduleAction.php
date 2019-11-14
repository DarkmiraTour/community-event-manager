<?php

declare(strict_types=1);

namespace App\Schedule\Delete;

use App\Schedule\ScheduleRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class DeleteScheduleAction
{
    private $router;
    private $csrfTokenManager;
    private $scheduleRepository;

    public function __construct(
        ScheduleRepositoryInterface $scheduleRepository,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request, string $id): RedirectResponse
    {
        $schedule = $this->scheduleRepository->find($id);

        if (!$schedule) {
            throw new NotFoundHttpException();
        }

        $token = new CsrfToken('delete'.$id, $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->scheduleRepository->remove($schedule);
        }

        return new RedirectResponse($this->router->generate('schedule_index'));
    }
}
