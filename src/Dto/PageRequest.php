<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Page;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

final class PageRequest
{
    /**
     * @Assert\NotBlank(groups={"addFile"})
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @Assert\NotBlank(groups={"addFile"})
     * @Assert\NotBlank()
     */
    public $content;

    /**
     * @Assert\NotBlank(groups={"addFile"})
     * @Assert\Image(mimeTypes={"image/png", "image/jpeg"}, groups={"addFile"})
     * @Assert\File(maxSize="5M", groups={"addFile"})
     *
     * @Assert\Image(mimeTypes={"image/png", "image/jpeg"})
     * @Assert\File(maxSize="5M")
     */
    public $background;

    /**
     * @Assert\Length(max=255)
     */
    public $backgroundPath;

    public static function createFromEntity(Page $page): PageRequest
    {
        $pageRequest = new self();
        $pageRequest->title = $page->getTitle();
        $pageRequest->content = $page->getContent();
        $pageRequest->background = new File($page->getBackground(), false);
        $pageRequest->backgroundPath = $page->getBackground();

        return $pageRequest;
    }

    public function updateEntity(Page $page): void
    {
        $page->updatePage($this->title, $this->content, $this->backgroundPath);
    }
}
