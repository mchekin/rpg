<?php

namespace App\Modules\Equipment\Domain\Services;

use App\Modules\Equipment\Domain\Commands\CreateItemCommand;
use App\Modules\Equipment\Domain\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Domain\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Domain\Factories\ItemFactory;

class ItemService
{
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;
    /**
     * @var ItemFactory
     */
    private $itemFactory;
    /**
     * @var ItemPrototypeRepositoryInterface
     */
    private $itemPrototypeRepository;

    public function __construct(
        ItemRepositoryInterface $itemRepository,
        ItemPrototypeRepositoryInterface $itemPrototypeRepository,
        ItemFactory $itemFactory
    ) {
        $this->itemRepository = $itemRepository;
        $this->itemPrototypeRepository = $itemPrototypeRepository;
        $this->itemFactory = $itemFactory;
    }

    public function create(CreateItemCommand $createItemCommand): Item
    {
        $itemPrototype = $this->itemPrototypeRepository->getOne($createItemCommand->getPrototypeId());

        $item = $this->itemFactory->create($itemPrototype, $createItemCommand->getCreatorCharacterId());

        $this->itemRepository->add($item);

        return $item;
    }
}