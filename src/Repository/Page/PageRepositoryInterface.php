<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Entity\Page;

interface PageRepositoryInterface
{
    public function createPage(string $title, string $content, string $background): Page;

    /**
     * @param mixed    $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     * @return Page|null
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?Page;

    public function findAll(): array;

    public function save(Page $page): void;

    public function remove(Page $page): void;
}
