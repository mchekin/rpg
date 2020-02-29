<?php declare(strict_types=1);


namespace App\Modules\Equipment\Application\Services;


use App\Modules\Character\Application\Contracts\CharacterRepositoryInterface;
use App\Modules\Equipment\Application\Commands\AddItemToInventoryCommand;
use App\Modules\Equipment\Application\Commands\EquipItemCommand;
use App\Modules\Equipment\Application\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Item;

class InventoryService
{
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;
    /**
     * @var CharacterRepositoryInterface
     */
    private $characterRepository;

    public function __construct(ItemRepositoryInterface $itemRepository, CharacterRepositoryInterface $characterRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->characterRepository = $characterRepository;
    }

    public function equipItem(EquipItemCommand $command): void
    {
        $item = $this->itemRepository->getOne($command->getItemId());
        $character = $this->characterRepository->getOne($command->getOwnerCharacterId());

        if (!$item->isEquipped() && $character->getInventory()->hasItem($item)) {
            $equippedItem = $character->getInventory()->findEquippedItemOfType($item->getType());

            if ($equippedItem !== null) {
                /** @var Item $equippedItem */
                $equippedItem->unEquip();
                $this->itemRepository->update($equippedItem);
            }

            $item->equip();

            $this->itemRepository->update($item);
        }
    }

    public function unEquipItem(EquipItemCommand $command): void
    {
        $item = $this->itemRepository->getOne($command->getItemId());
        $character = $this->characterRepository->getOne($command->getOwnerCharacterId());

        if ($item->isEquipped() && $character->getInventory()->hasItem($item)) {
            /** @var Item $item */
            $item->unEquip();
            $this->itemRepository->update($item);
        }
    }

    public function addItemToInventory(AddItemToInventoryCommand $command): void
    {
        $character = $this->characterRepository->getOne($command->getCharacterId());
        $item = $this->itemRepository->getOne($command->getItemId());

        $character->addItemToInventorySlot($command->getSlot(), $item);

        $this->characterRepository->update($character);
    }
}
