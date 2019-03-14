<?php

declare(strict_types=1);

namespace App\Controller\InterviewQuestion;

use App\Repository\Schedule\InterviewQuestion\InterviewQuestionManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class Delete
{
    private $interviewQuestionManager;
    private $router;
    private $csrfTokenManager;

    public function __construct(
        InterviewQuestionManagerInterface $interviewQuestionManager,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->interviewQuestionManager = $interviewQuestionManager;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function handle(Request $request): RedirectResponse
    {
        $interviewQuestion = $this->interviewQuestionManager->find($request->attributes->get('id'));

        $token = new CsrfToken('delete'.$interviewQuestion->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->interviewQuestionManager->remove($interviewQuestion);
        }

        return new RedirectResponse($this->router->generate('interview_question_index'));
    }
}
