<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

interface renderPageInterface
{
    public function render(string $name, array $context): Response;
}
