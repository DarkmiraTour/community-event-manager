<?php

declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Dto\SpeakerTalkCsvUploadRequest;
use App\Form\UploadSpeakerFromCsvType;
use App\Repository\SpeakerRepositoryInterface;
use App\Repository\TalkRepositoryInterface;
use App\Service\FileUploaderInterface;
use App\Service\UploadFromOpenCFP\UploadedCsvCreateSpeakerTalk;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class UploadFromOpenCfp
{
    private $renderer;
    private $speakerRepository;
    private $talkRepository;
    private $formFactory;
    private $router;
    private $fileUploader;
    private $uploadedCsvCreateSpeakerTalk;

    public function __construct(
        Twig $renderer,
        SpeakerRepositoryInterface $speakerRepository,
        TalkRepositoryInterface $talkRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        FileUploaderInterface $fileUploader,
        UploadedCsvCreateSpeakerTalk $uploadedCsvCreateSpeakerTalk
    ) {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->talkRepository = $talkRepository;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->fileUploader = $fileUploader;
        $this->uploadedCsvCreateSpeakerTalk = $uploadedCsvCreateSpeakerTalk;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $speakerTalkCsvUploadRequest = new SpeakerTalkCsvUploadRequest();
        $form = $this->formFactory->create(UploadSpeakerFromCsvType::class, $speakerTalkCsvUploadRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->uploadedCsvCreateSpeakerTalk->createWithContent(
                $speakerTalkCsvUploadRequest->emailExportCsvFile->getFileInfo()->openFile(),
                $speakerTalkCsvUploadRequest->talkExportCsvFile->getFileInfo()->openFile()
            );

            $this->uploadedCsvCreateSpeakerTalk->saveAddedSpeakers();
            $this->uploadedCsvCreateSpeakerTalk->saveAddedTalks();

            return new Response($this->renderer->render('uploadFromOpenCfp/uploadFromOpenCfpResult.html.twig', [
                'addedSpeakers' => $this->uploadedCsvCreateSpeakerTalk->getAddedSpeakers(),
                'addedTalks' => $this->uploadedCsvCreateSpeakerTalk->getAddedTalks(),
            ]));
        }

        return new Response($this->renderer->render('uploadFromOpenCfp/uploadFromOpenCfp.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
