<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\Modules\Equipment\Domain\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\Item;
use Doctrine\ORM\EntityManager;

class ItemRepository implements ItemRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Item $item
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function add(Item $item): void
    {
        $this->entityManager->persist($item);
    }

    /**
     * @param string $itemId
     *
     * @return Item
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getOne(string $itemId): Item
    {
        /** @var Item $item */
        $item = $this->entityManager->find(Item::class, $itemId);

        return $item;
    }
}
