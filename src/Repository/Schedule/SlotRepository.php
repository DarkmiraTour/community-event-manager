<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Dto\SlotRequest;
use App\Entity\Slot;
use App\Entity\Space;
use App\Schedule\Schedule;
use App\Talk\Talk;
use App\ValueObject\Title;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SlotRepository implements SlotRepositoryInterface
{
    private $entityManager;
    private $repository;
    private $spaceRepository;
    private $scheduleRepository;
    private $talkRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Slot::class);
        $this->spaceRepository = $entityManager->getRepository(Space::class);
        $this->scheduleRepository = $entityManager->getRepository(Schedule::class);
        $this->talkRepository = $entityManager->getRepository(Talk::class);
    }

    public function find(string $id): ?Slot
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria = [], array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function createFrom(SlotRequest $slotRequest): Slot
    {
        $diff = $slotRequest->end->diff($slotRequest->start);

        $duration = ($diff->h * 60) + $diff->i;

        $slot = new Slot(
            $this->nextIdentity(),
            new Title($slotRequest->title),
            $duration,
            $slotRequest->start,
            $slotRequest->end,
            $slotRequest->type,
            $this->spaceRepository->find($slotRequest->space)
        );
        $slot->setTalk($slotRequest->talk ? $this->talkRepository->find($slotRequest->talk) : null);

        return $slot;
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(Slot $slot): void
    {
        $this->slotExistsForThisSpaceAndTime($slot);

        $this->entityManager->persist($slot);
        $this->entityManager->flush();
    }

    public function slotExistsForThisSpaceAndTime(Slot $slot): void
    {
        $end = new \DateTime($slot->getEnd()->format('H:i:s'));

        $queryBuilder = $this->entityManager->createQueryBuilder()->select('MIN(s.end)')->from('App:Slot', 's');
        $queryBuilder
            ->where('s.end > :start')
            ->andWhere('s.space = :space')
            ->andWhere('s.id != :id')
            ->setParameter('start', $slot->getStart()->format('H:i:s'))
            ->setParameter('space', $slot->getSpace()->getId())
            ->setParameter('id', $slot->getId())
        ;

        $slotExists = $queryBuilder->getQuery()->execute()[0];

        if ($slotExists[1] && new \DateTime($slotExists[1]) < $end) {
            throw new \LogicException('A slot already exists for this space and time');
        }
    }

    public function remove(Slot $slot): void
    {
        $this->entityManager->remove($slot);
        $this->entityManager->flush();
    }
}
