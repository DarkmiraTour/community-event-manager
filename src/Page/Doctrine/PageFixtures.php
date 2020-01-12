<?php

declare(strict_types=1);

namespace App\Page\Doctrine;

use App\Page\PageManagerInterface;
use App\Service\FileUploaderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;
use Symfony\Component\HttpFoundation\File\File;

final class PageFixtures extends Fixture
{
    private $pageManager;
    private $fileUploader;
    private $faker;

    public function __construct(PageManagerInterface $pageManager, FileUploaderInterface $fileUploader, Generator $faker)
    {
        $this->pageManager = $pageManager;
        $this->fileUploader = $fileUploader;
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager): void
    {
        for ($pageNbr = 0; $pageNbr < 3; $pageNbr++) {
            $page = $this->pageManager->createWith(
                "Page {$pageNbr}",
                $this->faker->text(),
                $this->fileUploader->upload(new File($this->faker->image('/tmp', 240, 240)))
            );
            $manager->persist($page);
        }
        $manager->flush();
    }
}
