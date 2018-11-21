<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Page;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

final class PageRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @Assert\NotBlank()
     */
    public $content;

    /**
     * @Assert\Image(mimeTypes={"image/png", "image/jpeg"})
     * @Assert\File(maxSize="5M")
     */
    public $background;

    /**
     * @Assert\Length(max=255)
     */
    public $backgroundPath;

    public function __construct(string $title, string $content, File $background, ?string $backgroundPath = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->background = $background;
        $this->backgroundPath = $backgroundPath;
    }

    public static function createFromEntity(Page $page): PageRequest
    {
        return new self(
            $page->getTitle(),
            $page->getContent(),
            new File($page->getBackground(), false),
            $page->getBackground()
        );
    }

    public function updateEntity(Page $page): void
    {
        $page->updatePage($this->title, $this->content, $this->backgroundPath);
    }

    public function updateFromForm(string $title, string $content, ?File $background = null): void
    {
        $this->title = $title;
        $this->content = $content;
        $this->background = $background;
    }
}
