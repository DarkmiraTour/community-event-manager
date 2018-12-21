<?php

declare(strict_types=1);

namespace App\Controller\SlotType;

use App\Repository\Schedule\SlotTypeRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $slotTypeRepository;

    public function __construct(
        Twig $renderer,
        SlotTypeRepositoryInterface $slotTypeRepository
    ) {
        $this->renderer = $renderer;
        $this->slotTypeRepository = $slotTypeRepository;
    }

    public function handle(): Response
    {
        return new Response($this->renderer->render('schedule/slotType/index.html.twig', [
            'slotTypes' => $this->slotTypeRepository->findAll(),
        ]));
    }
}
