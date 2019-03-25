<?php

declare(strict_types=1);

namespace App\Controller\Event;

use App\Dto\EventRequest;
use App\Form\EventType;
use App\Repository\Event\EventRepositoryInterface;
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
    public const FORM_ACTION = 'edit';
    private $renderer;
    private $router;
    private $formFactory;
    private $repository;
    private $fileUploader;

    public function __construct(
        Twig $renderer,
        EventRepositoryInterface $repository,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        FileUploaderInterface $fileUploader
    ) {
        $this->renderer = $renderer;
        $this->repository = $repository;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $event = $this->repository->findById($id);
        if (!$event) {
            throw new NotFoundHttpException(sprintf('The event could not be found this this id %s', $id));
        }

        $eventRequest = EventRequest::createFromEvent($event);
        $form = $this->formFactory->create(EventType::class, $eventRequest, ['method' => 'put']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $eventRequest->updateEvent($event);
            $this->repository->save($event);

            return new RedirectResponse($this->router->generate('event_show', [
                'id' => $event->getId(),
            ]));
        }

        return new Response($this->renderer->render('event/create.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'action' => self::FORM_ACTION,
        ]));
    }
}
