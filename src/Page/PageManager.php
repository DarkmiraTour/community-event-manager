<?php

declare(strict_types=1);

namespace App\Page;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PageManager implements PageManagerInterface
{
    private $repository;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $id): Page
    {
        return $this->checkEntity($this->repository->find($id));
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

    public function save(Page $page): void
    {
        $this->repository->save($page);
    }

    public function remove(Page $page): void
    {
        $this->repository->remove($page);
    }

    private function checkEntity(?Page $page): Page
    {
        if (!$page) {
            throw new NotFoundHttpException();
        }

        return $page;
    }
}
