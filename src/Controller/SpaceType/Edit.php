<?php

declare(strict_types=1);

namespace App\Controller\SpaceType;

use App\Dto\SpaceTypeRequest;
use App\Form\SpaceTypeType;
use App\Repository\Schedule\SpaceTypeRepositoryInterface;
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
    private $formFactory;
    private $spaceTypeRepository;
    private $router;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        SpaceTypeRepositoryInterface $spaceTypeRepository,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->spaceTypeRepository = $spaceTypeRepository;
        $this->router = $router;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $spaceType = $this->spaceTypeRepository->find($id);
        if (!$spaceType) {
            throw new NotFoundHttpException();
        }

        $spaceTypeRequest = SpaceTypeRequest::createFromEntity($spaceType);
        $form = $this->formFactory->create(SpaceTypeType::class, $spaceTypeRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $spaceType = $spaceTypeRequest->updateEntity($spaceType);
            $this->spaceTypeRepository->save($spaceType);

            return new RedirectResponse($this->router->generate('schedule_space_type_index'));
        }

        return new Response($this->renderer->render('schedule/spaceType/edit.html.twig', [
            'spaceType' => $spaceType,
            'form' => $form->createView(),
        ]));
    }

}
