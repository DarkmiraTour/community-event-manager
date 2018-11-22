<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Repository\Page\PageManagerInterface;
use App\Service\FileUploaderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Faker\Factory as Faker;

final class PageFixtures extends Fixture
{
    private $pageManager;
    private $fileUploader;

    public function __construct(PageManagerInterface $pageManager, FileUploaderInterface $fileUploader)
    {
        $this->pageManager = $pageManager;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();
        for ($pageNbr = 0; $pageNbr < 3; $pageNbr++) {
            $page = $this->pageManager->createWith(
                "Page {$pageNbr}",
                $faker->text(),
                $this->fileUploader->upload(new File($faker->image('/tmp', 240, 240)))
            );
            $manager->persist($page);
        }
        $manager->flush();
    }
}
