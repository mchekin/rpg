<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\Modules\Equipment\Domain\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\ItemPrototype;
use Doctrine\ORM\EntityManager;

class ItemPrototypeRepository implements ItemPrototypeRepositoryInterface
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
     * @param string $itemPrototypeId
     * @return ItemPrototype
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getOne(string $itemPrototypeId): ItemPrototype
    {
        /** @var ItemPrototype $prototype */
        $prototype = $this->entityManager->find(ItemPrototype::class, $itemPrototypeId);

        return $prototype;
    }
}
