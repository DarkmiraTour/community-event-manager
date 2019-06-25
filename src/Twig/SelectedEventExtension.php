<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use App\Service\Event\EventServiceInterface;

final class SelectedEventExtension extends AbstractExtension implements GlobalsInterface
{
    private $eventService;

    public function __construct(EventServiceInterface $eventService)
    {
        $this->eventService = $eventService;
    }

    public function getGlobals(): array
    {
        return [
            'selectedEvent' => $this->eventService->isEventSelected()
                ? $this->eventService->getSelectedEvent()
                : null,
        ];
    }
}
