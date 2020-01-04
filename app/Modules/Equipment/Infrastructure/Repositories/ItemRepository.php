<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\Modules\Equipment\Domain\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Infrastructure\ReconstitutionFactories\ItemReconstitutionFactory;
use Doctrine\ORM\EntityManager;

class ItemRepository implements ItemRepositoryInterface
{
    /**
     * @var ItemReconstitutionFactory
     */
    private $reconstitutionFactory;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        ItemReconstitutionFactory $reconstitutionFactory,
        EntityManager $entityManager
    ) {
        $this->reconstitutionFactory = $reconstitutionFactory;
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
