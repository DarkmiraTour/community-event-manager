<?php

declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Dto\SpeakerRequest;
use App\Form\SpeakerType;
use App\Repository\SpeakerEventInterviewSent\SpeakerEventRepositoryInterface;
use App\Repository\SpeakerRepositoryInterface;
use App\Service\Event\EventServiceInterface;
use App\Service\FileUploaderInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Edit
{
    private $renderer;
    private $router;
    private $formFactory;
    private $speakerRepository;
    private $speakerEventRepository;
    private $fileUploader;
    private $eventService;

    public function __construct(
        Twig $renderer,
        SpeakerRepositoryInterface $speakerRepository,
        SpeakerEventRepositoryInterface $speakerEventRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        FileUploaderInterface $fileUploader,
        EventServiceInterface $eventService
    ) {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->speakerEventRepository = $speakerEventRepository;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->fileUploader = $fileUploader;
        $this->eventService = $eventService;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $speaker = $this->speakerRepository->find($id);
        if ($this->eventService->isEventSelected()) {
            $event = $this->eventService->getSelectedEvent();
            $speakerEvent = $this->speakerEventRepository->findBySpeakerAndEvent($speaker, $event);
        }

        if (!$speaker) {
            throw new NotFoundHttpException();
        }

        $speakerRequest = SpeakerRequest::createFromEntity($speaker, $speakerEvent ?? null);
        $form = $this->formFactory->create(SpeakerType::class, $speakerRequest);

        if (!$this->eventService->isEventSelected()) {
            $form->remove('isInterviewSent');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($speakerRequest->photo)) {
                $speakerRequest->photoPath = $this->fileUploader->upload($speakerRequest->photo);
            }

            $speaker = $speakerRequest->updateEntity($speaker, $speakerEvent ?? null);
            $this->speakerRepository->save($speaker);
            if (isset($speakerEvent)) {
                $this->speakerEventRepository->save($speakerEvent);
            }

            return new RedirectResponse($this->router->generate('speaker_show', [
                'id' => $speaker->getId(),
            ]));
        }

        return new Response($this->renderer->render('speaker/edit.html.twig', [
            'speaker' => $speaker,
            'form' => $form->createView(),
        ]));
    }
}
