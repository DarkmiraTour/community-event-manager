<?php

declare(strict_types=1);

namespace App\Controller\InterviewQuestion;

use App\Repository\Schedule\InterviewQuestion\InterviewQuestionRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class DeleteConfirmation
{
    private $repository;
    private $renderer;

    public function __construct(
        InterviewQuestionRepositoryInterface $repository,
        Twig $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(string $id): Response
    {
        $interviewQuestion = $this->repository->find($id);

        return new Response($this->renderer->render('schedule/interviewQuestion/confirm_delete.html.twig', [
            'interviewQuestion' => $interviewQuestion,
        ]));
    }
}
