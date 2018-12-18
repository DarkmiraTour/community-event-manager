<?php

declare(strict_types=1);

namespace App\Controller\Page;

use App\Dto\PageRequest;
use App\Form\PageType;
use App\Repository\Page\PageManagerInterface;
use App\Service\FileUploaderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Edit
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
        $page = $this->pageManager->find($request->attributes->get('id'));

        $pageRequest = PageRequest::createFromEntity($page);
        $backgroundPath = $pageRequest->backgroundPath;

        $form = $this->formFactory->create(PageType::class, $pageRequest, [
            'method' => 'put',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageRequest = $form->getData();
            $pageRequest->backgroundPath = !empty($pageRequest->background) ? $this->fileUploader->upload($pageRequest->background) : $backgroundPath;

            $pageRequest->updateEntity($page);
            $this->pageManager->save($page);

            return new RedirectResponse($this->router->generate('page_index'));
        }

        return new Response($this->renderer->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]));
    }
}
