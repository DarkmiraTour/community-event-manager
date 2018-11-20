<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Entity\Page;
use App\Dto\PageRequest;

final class PageManager implements PageManagerInterface
{
    private $repository;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $id): ?Page
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function createFrom(PageRequest $pageRequest): Page
    {
        return $this->repository->createPage($pageRequest->title, $pageRequest->content, $pageRequest->backgroundPath);
    }

    public function createWith(string $title, string $content, string $background): Page
    {
        return $this->repository->createPage($title, $content, $background);
    }

    /**
     * @param Page $page
     */
    public function save(Page $page): void
    {
        $this->repository->save($page);
    }

    /**
     * @param Page $page
     */
    public function remove(Page $page): void
    {
        $this->repository->remove($page);
    }
}
