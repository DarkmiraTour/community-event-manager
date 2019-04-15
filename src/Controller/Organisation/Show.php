<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Repository\Organisation\OrganisationRepositoryInterface;
use App\Repository\OrganisationSponsor\OrganisationSponsorRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

final class Show
{
    private $renderer;
    private $repository;
    private $organisationSponsorRepository;

    public function __construct(Twig $renderer, OrganisationRepositoryInterface $repository, OrganisationSponsorRepositoryInterface $organisationSponsorRepository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
        $this->organisationSponsorRepository = $organisationSponsorRepository;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(string $id): Response
    {
        $organisation = $this->repository->find($id);
        $organisationSponsor = $this->organisationSponsorRepository->findBy(['organisation' => $id]);

        if (null === $organisation) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('organisations/show.html.twig', [
            'organisation' => $organisation,
            'organisationSponsor' => $organisationSponsor,
        ]));
    }
}
