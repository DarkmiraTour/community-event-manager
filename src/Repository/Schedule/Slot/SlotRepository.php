<?php

declare(strict_types=1);

namespace App\Repository\Schedule\Slot;

use App\Entity\Slot;
use App\Entity\SlotType;
use App\Entity\Space;
use App\Entity\Talk;
use App\Exceptions\SlotAlreadyExistException;
use App\ValueObject\Title;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class SlotRepository extends ServiceEntityRepository implements SlotRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Slot::class);
    }

    public function createSlot(string $title, SlotType $slotType, int $duration, \DateTimeInterface $start, \DateTimeInterface $end, Space $space, ?Talk $talk): Slot
    {
        return new Slot(
            $this->nextIdentity(),
            new Title($title),
            $slotType,
            $duration,
            $start,
            $end,
            $space,
            $talk
        );
    }

    public function save(Slot $slot): void
    {
        $this->slotExistsForThisSpaceAndTime($slot);

        $this->getEntityManager()->persist($slot);
        $this->getEntityManager()->flush();
    }

    public function remove(Slot $slot): void
    {
        $this->getEntityManager()->remove($slot);
        $this->getEntityManager()->flush();
    }

    public function find($id, $lockMode = null, $lockVersion = null): ?Slot
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    public function slotExistsForThisSpaceAndTime(Slot $slot): void
    {
        $end = new \DateTime($slot->getEnd()->format('H:i:s'));

        $queryBuilder = $this->createQueryBuilder('s')
            ->select('MIN(s.end)')
            ->where('s.end > :start')
            ->andWhere('s.space = :space')
            ->andWhere('s.id != :id')
            ->setParameter('start', $slot->getStart()->format('H:i:s'))
            ->setParameter('space', $slot->getSpace()->getId())
            ->setParameter('id', $slot->getId())
        ;

        $slotExists = $queryBuilder->getQuery()->execute()[0];

        if ($slotExists[1] && new \DateTime($slotExists[1]) < $end) {
            throw new SlotAlreadyExistException();
        }
    }

    /**
     * @return UuidInterface
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    private function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
