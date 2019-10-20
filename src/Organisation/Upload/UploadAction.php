<?php

declare(strict_types=1);

namespace App\Organisation\Upload;

use App\Action;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class UploadAction implements Action
{
    private $renderer;
    private $formFactory;
    private $router;
    private $fileCsvUploader;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        FileCsvUploaderInterface $fileCsvUploader
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->fileCsvUploader = $fileCsvUploader;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $organisationCsvUploadRequest = new OrganisationCsvUploadRequest();

        $form = $this->formFactory->create(OrganisationCsvUploadFormType::class, $organisationCsvUploadRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pathName = $organisationCsvUploadRequest->name->getPathname();

            $csvData = $this->fileCsvUploader->read($pathName);
            $this->fileCsvUploader->import($csvData);

            return new RedirectResponse($this->router->generate('organisation_list'));
        }

        return new Response($this->renderer->render('organisations/upload.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
