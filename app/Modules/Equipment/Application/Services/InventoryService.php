<?php declare(strict_types=1);


namespace App\Modules\Equipment\Application\Services;

use App\Modules\Equipment\Application\Commands\CreateInventoryCommand;
use App\Modules\Equipment\Application\Commands\EquipItemCommand;
use App\Modules\Equipment\Application\Contracts\InventoryRepositoryInterface;
use App\Modules\Equipment\Domain\Inventory;
use Illuminate\Support\Collection;

class InventoryService
{
    /**
     * @var InventoryRepositoryInterface
     */
    private $inventoryRepository;

    public function __construct(InventoryRepositoryInterface $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function create(CreateInventoryCommand $command):Inventory
    {
        $id = $this->inventoryRepository->nextIdentity();

        $inventory = new Inventory($id, $command->getCharacterId(), Collection::make());

        $this->inventoryRepository->add($inventory);

        return $inventory;
    }

    public function equipItem(EquipItemCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getOwnerCharacterId());

        $inventory->equip($command->getItemId());

        $this->inventoryRepository->update($inventory);
    }

    public function unEquipItem(EquipItemCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getOwnerCharacterId());

        $inventory->unEquipItem($command->getItemId());

        $this->inventoryRepository->update($inventory);
    }
}
