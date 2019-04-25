<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Dto\OrganisationCsvUploadRequest;
use App\Form\OrganisationCsvUploadType;
use App\Repository\Organisation\OrganisationRepositoryInterface;
use League\Csv\Reader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Upload
{
    private $renderer;
    private $formFactory;
    private $repository;
    private $router;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        OrganisationRepositoryInterface $repository,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->repository = $repository;
        $this->router = $router;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $organisationCsvUploadRequest = new OrganisationCsvUploadRequest();

        $form = $this->formFactory->create(OrganisationCsvUploadType::class, $organisationCsvUploadRequest);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $organisationCsvUploadRequest->name->getPathname();

            Reader::createFromPath($file)
                ->setHeaderOffset(0);
        }

        return new Response($this->renderer->render('organisations/upload.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
