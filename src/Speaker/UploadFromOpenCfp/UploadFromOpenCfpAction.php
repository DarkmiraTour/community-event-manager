<?php

declare(strict_types=1);

namespace App\Speaker\UploadFromOpenCfp;

use App\Action;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class UploadFromOpenCfpAction implements Action
{
    private $renderer;
    private $formFactory;
    private $uploadedCsvCreateSpeakerTalkService;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        UploadedCsvCreateSpeakerTalkService $uploadedCsvCreateSpeakerTalkService
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->uploadedCsvCreateSpeakerTalkService = $uploadedCsvCreateSpeakerTalkService;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $speakerTalkCsvUploadRequest = new SpeakerTalkCsvUploadRequest();
        $form = $this->formFactory->create(UploadSpeakerFromCsvFormType::class, $speakerTalkCsvUploadRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->uploadedCsvCreateSpeakerTalkService->createWithContent(
                $speakerTalkCsvUploadRequest->emailExportCsvFile->getFileInfo()->openFile(),
                $speakerTalkCsvUploadRequest->talkExportCsvFile->getFileInfo()->openFile()
            );

            $this->uploadedCsvCreateSpeakerTalkService->saveAddedSpeakers();
            $this->uploadedCsvCreateSpeakerTalkService->saveAddedTalks();

            return new Response($this->renderer->render('uploadFromOpenCfp/uploadFromOpenCfpResult.html.twig', [
                'addedSpeakers' => $this->uploadedCsvCreateSpeakerTalkService->getAddedSpeakers(),
                'addedTalks' => $this->uploadedCsvCreateSpeakerTalkService->getAddedTalks(),
            ]));
        }

        return new Response($this->renderer->render('uploadFromOpenCfp/uploadFromOpenCfp.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
