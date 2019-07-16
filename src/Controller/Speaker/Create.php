<?php

declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Dto\SpeakerRequest;
use App\Form\SpeakerType;
use App\Repository\SpeakerRepositoryInterface;
use App\Service\FileUploaderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $renderer;
    private $speakerRepository;
    private $formFactory;
    private $router;
    private $fileUploader;
    private $urlGenerator;
    private $assetPackage;

    public function __construct(
        Twig $renderer,
        SpeakerRepositoryInterface $speakerRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        FileUploaderInterface $fileUploader,
        UrlGeneratorInterface $urlGenerator,
        Packages $assetPackage
    ) {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->fileUploader = $fileUploader;
        $this->urlGenerator = $urlGenerator;
        $this->assetPackage = $assetPackage;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $speakerRequest = new SpeakerRequest();
        $form = $this->formFactory->create(SpeakerType::class, $speakerRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $speakerRequest->photoPath = $this->urlGenerator->generate('index', [], UrlGeneratorInterface::ABSOLUTE_URL).$this->assetPackage->getUrl(DIRECTORY_SEPARATOR.'images/default_speaker.svg');
            if (!empty($speakerRequest->photo)) {
                $speakerRequest->photoPath = $this->fileUploader->upload($speakerRequest->photo);
            }

            $speaker = $this->speakerRepository->createFromRequest($speakerRequest);
            $this->speakerRepository->save($speaker);

            return new RedirectResponse($this->router->generate('speaker_index'));
        }

        return new Response($this->renderer->render('speaker/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
