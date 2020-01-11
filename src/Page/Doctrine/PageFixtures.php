<?php

declare(strict_types=1);

namespace App\Page\Doctrine;

use App\Faker\Provider\PicsumImage;
use App\Page\PageManagerInterface;
use App\Service\FileUploaderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\HttpFoundation\File\File;

final class PageFixtures extends Fixture
{
    private $pageManager;
    private $fileUploader;

    public function __construct(PageManagerInterface $pageManager, FileUploaderInterface $fileUploader)
    {
        $this->pageManager = $pageManager;
        $this->fileUploader = $fileUploader;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();
        $faker->addProvider(new PicsumImage($faker));

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
