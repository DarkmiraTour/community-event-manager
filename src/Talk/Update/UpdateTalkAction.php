<?php

declare(strict_types=1);

namespace App\Talk\Update;

use App\Action;
use App\Talk\TalkRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class UpdateTalkAction implements Action
{
    private $renderer;
    private $formFactory;
    private $talkRepository;
    private $router;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        TalkRepositoryInterface $talkRepository,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->talkRepository = $talkRepository;
        $this->router = $router;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $talk = $this->talkRepository->find($id);
        if (!$talk) {
            throw new NotFoundHttpException();
        }

        $updateTalkRequest = UpdateTalkRequest::createFromEntity($talk);
        $form = $this->formFactory->create(UpdateTalkFormType::class, $updateTalkRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $talk = $updateTalkRequest->updateEntity($talk);
            $this->talkRepository->save($talk);

            return new RedirectResponse($this->router->generate('talk_show', [
                'id' => $talk->getId(),
            ]));
        }

        return new Response($this->renderer->render('talks/edit.html.twig', [
            'talk' => $talk,
            'form' => $form->createView(),
        ]));
    }
}
