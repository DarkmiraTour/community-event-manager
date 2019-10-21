<?php

declare(strict_types=1);

namespace App\Page;

interface PageRepositoryInterface
{
    public function createPage(string $title, string $content, string $background): Page;

    public function find($id, $lockMode = null, $lockVersion = null): ?Page;

    public function findAll(): array;

    public function save(Page $page): void;

    public function remove(Page $page): void;
}
