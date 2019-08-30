<?php

declare(strict_types=1);

namespace App\Talk\Create;

use App\Action;
use App\Talk\TalkRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class CreateTalkAction implements Action
{
    private $renderer;
    private $formFactory;
    private $talkRepository;
    private $talkFactory;
    private $router;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        TalkRepositoryInterface $talkRepository,
        TalkFactory $talkFactory,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->talkRepository = $talkRepository;
        $this->talkFactory = $talkFactory;
        $this->router = $router;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $form = $this->formFactory->create(CreateTalkFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $talkRequest = $form->getData();
            $talk = $this->talkFactory->createFromRequest($talkRequest);
            $this->talkRepository->save($talk);

            return new RedirectResponse($this->router->generate('talk_index'));
        }

        return new Response($this->renderer->render('talks/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
