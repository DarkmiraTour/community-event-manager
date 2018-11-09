<?php declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Dto\SpeakerRequest;
use App\Form\SpeakerType;
use App\Repository\SpeakerRepositoryInterface;
use App\Service\FileUploaderInterface;
use Ramsey\Uuid\Uuid;
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
    private $fileUploader;

    public function __construct(
        Twig $renderer,
        SpeakerRepositoryInterface $speakerRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        FileUploaderInterface $fileUploader
    ) {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->fileUploader = $fileUploader;
    }

    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $speaker = $this->speakerRepository->find($id);
        if (!$speaker) {
            throw new NotFoundHttpException();
        }

        $speakerRequest = SpeakerRequest::createFromEntity($speaker);
        $form = $this->formFactory->create(SpeakerType::class, $speakerRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($speakerRequest->photo)) {
                $speakerRequest->photoPath = $this->fileUploader->upload($speakerRequest->photo);
            }

            $speaker = $speakerRequest->updateEntity($speaker);
            $this->speakerRepository->save($speaker);

            return new RedirectResponse($this->router->generate('speaker_edit', [
                'id' => $speaker->getId(),
            ]));
        }

        return new Response($this->renderer->render('speaker/edit.html.twig', [
            'speaker' => $speaker,
            'form' => $form->createView(),
        ]));
    }
}
