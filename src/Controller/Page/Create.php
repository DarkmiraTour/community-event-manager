<?php

declare(strict_types=1);

namespace App\Controller\Page;

use App\Form\PageType;
use App\Repository\Page\PageManagerInterface;
use App\Service\FileUploaderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $renderer;
    private $pageManager;
    private $formFactory;
    private $router;
    private $fileUploader;

    public function __construct(
        Twig $renderer,
        PageManagerInterface $pageManager,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        FileUploaderInterface $fileUploader
    ) {
        $this->renderer = $renderer;
        $this->pageManager = $pageManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->fileUploader = $fileUploader;
    }

    public function handle(Request $request): Response
    {
        $form = $this->formFactory->create(PageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageRequest = $form->getData();
            $pageRequest->backgroundPath = $this->fileUploader->upload($pageRequest->background);

            $page = $this->pageManager->createFrom($pageRequest);
            $this->pageManager->save($page);

            return new RedirectResponse($this->router->generate('page_index'));
        }

        return new Response($this->renderer->render('page/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
