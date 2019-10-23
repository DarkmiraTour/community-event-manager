<?php

declare(strict_types=1);

namespace App\Twig;

use App\Service\Event\EventServiceInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

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
