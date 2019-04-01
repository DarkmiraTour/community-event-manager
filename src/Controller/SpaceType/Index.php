<?php

declare(strict_types=1);

namespace App\Controller\SpaceType;

use App\Repository\Schedule\SpaceTypeRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $spaceTypeRepository;

    public function __construct(Twig $renderer, SpaceTypeRepositoryInterface $spaceTypeRepository)
    {
        $this->renderer = $renderer;
        $this->spaceTypeRepository = $spaceTypeRepository;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(): Response
    {
        $spaceTypes = $this->spaceTypeRepository->findAll();

        return new Response($this->renderer->render('schedule/spaceType/index.html.twig', [
            'spaceTypes' => $spaceTypes,
        ]));
    }
}
