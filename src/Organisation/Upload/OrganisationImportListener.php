<?php

declare(strict_types=1);

namespace App\Organisation\Upload;

use App\Organisation\OrganisationRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class OrganisationImportListener
{
    private $repository;
    private $eventDispatcher;

    public function __construct(OrganisationRepositoryInterface $repository, EventDispatcherInterface $eventDispatcher)
    {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function onOrganisationImported(OrganisationImportEvent $eventOrganisation): void
    {
        $this->eventDispatcher->addListener(KernelEvents::TERMINATE, function () use ($eventOrganisation): void {
            $this->repository->save($eventOrganisation->getOrganisation());
        });
    }
}
