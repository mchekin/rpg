<?php

namespace App\Modules\Equipment\Domain\Services;

use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Equipment\Domain\Commands\CreateItemCommand;
use App\Modules\Equipment\Domain\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Domain\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\Item;
use Illuminate\Support\Facades\DB;

class ItemService
{
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;
    /**
     * @var ItemPrototypeRepositoryInterface
     */
    private $itemPrototypeRepository;
    /**
     * @var CharacterRepositoryInterface
     */
    private $characterRepository;

    public function __construct(
        CharacterRepositoryInterface $characterRepository,
        ItemRepositoryInterface $itemRepository,
        ItemPrototypeRepositoryInterface $itemPrototypeRepository
    )
    {
        $this->characterRepository = $characterRepository;
        $this->itemRepository = $itemRepository;
        $this->itemPrototypeRepository = $itemPrototypeRepository;
    }

    public function create(CreateItemCommand $command): Item
    {
        return DB::transaction(function () use ($command) {
            $itemPrototype = $this->itemPrototypeRepository->getOne($command->getPrototypeId());
            $character = $this->characterRepository->getOne($command->getCreatorCharacterId());

            $item = $itemPrototype->createItem($character);

            $character->addItemToInventory($item);

            $this->itemRepository->add($item);

            return $item;
        });
    }
}
