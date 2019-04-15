<?php

declare(strict_types=1);

namespace App\Controller\OrganisationSponsor;

use App\Dto\OrganisationSponsorRequest;
use App\Form\OrganisationSponsorType;
use App\Repository\OrganisationSponsor\OrganisationSponsorRepositoryInterface;
use App\Repository\Organisation\OrganisationRepositoryInterface;
use App\Service\Event\EventServiceInterface;
use App\Exceptions\NoEventSelectedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $renderer;
    private $formFactory;
    private $repository;
    private $router;
    private $eventService;
    private $organisationRepository;
    private $flashBag;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        OrganisationSponsorRepositoryInterface $repository,
        OrganisationRepositoryInterface $organisationRepository,
        RouterInterface $router,
        EventServiceInterface $eventService,
        FlashBagInterface $flashBag
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->repository = $repository;
        $this->router = $router;
        $this->eventService = $eventService;
        $this->organisationRepository = $organisationRepository;
        $this->flashBag = $flashBag;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(Request $request): Response
    {
        $organisation = $this->organisationRepository->find($request->get('id'));

        if (null === $organisation) {
            throw new NotFoundHttpException();
        }
        $event = $this->eventService->getSelectedEvent();

        if (!$this->eventService->isUserLoggedIn() || !$this->eventService->isEventSelected()) {
            throw new NoEventSelectedException('No event has been selected');
        }

        $organisationSponsorRequest = new OrganisationSponsorRequest();
        $form = $this->formFactory->create(OrganisationSponsorType::class, $organisationSponsorRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $organisationSponsorRequest->specialBenefit && null === $organisationSponsorRequest->sponsorshipLevel) {
                $this->flashBag->add('danger', 'You must select at least one option');

                return new RedirectResponse($this->router->generate('organisation_sponsor_create', ['id' => $organisation->getId()]));
            }
            if ($organisationSponsor = $this->repository->findBy(['organisation' => $organisation, 'event' => $event])) {
                $this->flashBag->add('danger', 'This organisation is already sponsor of this event');

                return new RedirectResponse($this->router->generate('organisation_sponsor_create', ['id' => $organisation->getId()]));
            }
            $organisationSponsor = $this->repository->createFrom($organisationSponsorRequest);
            $organisationSponsor->setOrganisation($organisation);
            $organisationSponsor->setEvent($event);
            $this->repository->save($organisationSponsor);

            $this->flashBag->add('success', ' "'.$organisation->getName().'" organisation has been added to sponsor for the "'.$event->getName().'" event ');

            return new RedirectResponse($this->router->generate('organisation_list'));
        }

        return new Response($this->renderer->render('organisationSponsor/create.html.twig', ['form' => $form->createView()]));
    }
}
