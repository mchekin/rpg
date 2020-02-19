<?php

namespace App\Modules\Equipment\Application\Services;

use App\Modules\Character\Application\Contracts\CharacterRepositoryInterface;
use App\Modules\Equipment\Application\Commands\CreateItemCommand;
use App\Modules\Equipment\Application\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Application\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Application\Factories\ItemFactory;
use Illuminate\Support\Facades\DB;

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
    /**
     * @var \App\Modules\Character\Application\Contracts\CharacterRepositoryInterface
     */
    private $characterRepository;

    public function __construct(
        CharacterRepositoryInterface $characterRepository,
        ItemRepositoryInterface $itemRepository,
        ItemPrototypeRepositoryInterface $itemPrototypeRepository,
        ItemFactory $itemFactory
    )
    {
        $this->characterRepository = $characterRepository;
        $this->itemRepository = $itemRepository;
        $this->itemPrototypeRepository = $itemPrototypeRepository;
        $this->itemFactory = $itemFactory;
    }

    public function create(CreateItemCommand $command): Item
    {
        return DB::transaction(function () use ($command) {
            $itemPrototype = $this->itemPrototypeRepository->getOne($command->getPrototypeId());
            $character = $this->characterRepository->getOne($command->getCreatorCharacterId());

            $item = $this->itemFactory->create($itemPrototype, $character->getId());

            $character->addItemToInventory($item);

            $this->itemRepository->add($item);
            $this->characterRepository->update($character);

            return $item;
        });
    }
}
