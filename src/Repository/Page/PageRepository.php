<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PageRepository extends ServiceEntityRepository implements PageRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * @param string $title
     * @param string $content
     * @param string $background
     * @return Page
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function createPage(string $title, string $content, string $background): Page
    {
        return new Page(
            $this->nextIdentity(),
            $title,
            $content,
            $background
        );
    }

    /**
     * @param mixed    $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     * @return Page|null
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?Page
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    /**
     * @param Page $page
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Page $page): void
    {
        $this->getEntityManager()->persist($page);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Page $page
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Page $page): void
    {
        $this->getEntityManager()->remove($page);
        $this->getEntityManager()->flush();
    }

    /**
     * @return UuidInterface
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    private function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
