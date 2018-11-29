<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Entity\Page;
use App\Dto\PageRequest;

interface PageManagerInterface
{
    public function find(string $id): Page;

    /**
     * @return Page[]
     */
    public function findAll(): array;

    public function createFrom(PageRequest $pageRequest): Page;

    public function createWith(string $title, string $content, string $background): Page;

    public function save(Page $page): void;

    public function remove(Page $page): void;
}
