<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\Inventory as InventoryModel;
use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Application\Contracts\InventoryRepositoryInterface;
use App\Modules\Equipment\Domain\Inventory;
use App\Modules\Equipment\Domain\InventoryId;
use App\Modules\Equipment\Domain\InventoryItem;
use App\Modules\Equipment\Infrastructure\ReconstitutionFactories\InventoryReconstitutionFactory;
use App\Traits\GeneratesUuid;
use Exception;

class InventoryRepository implements InventoryRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @var InventoryReconstitutionFactory
     */
    private $reconstitutionFactory;

    public function __construct(InventoryReconstitutionFactory $reconstitutionFactory)
    {
        $this->reconstitutionFactory = $reconstitutionFactory;
    }

    /**
     * @return InventoryId
     *
     * @throws Exception
     */
    public function nextIdentity(): InventoryId
    {
        return InventoryId::fromString($this->generateUuid());
    }

    public function add(Inventory $inventory): void
    {
        InventoryModel::query()->create([
            'id' => $inventory->getId()->toString(),
            'character_id' => $inventory->getCharacterId()->toString(),
        ]);
    }

    public function forCharacter(CharacterId $characterId): Inventory
    {
        /** @var InventoryModel $model */
        $model = InventoryModel::query()->where('character_id', $characterId->toString())->firstOrFail();

        return $this->reconstitutionFactory->reconstitute($model);
    }

    public function update(Inventory $inventory): void
    {
        /** @var InventoryModel $inventoryModel */
        $inventoryModel = InventoryModel::query()->findOrFail($inventory->getId()->toString());

        $inventoryItems = $inventory->getItems()->mapWithKeys(static function (InventoryItem $item, int $slot) {
            $itemId = $item->getId()->toString();

            return [
                $itemId => [
                    'item_id' => $itemId,
                    'status' => $item->getStatus()->toString(),
                    'inventory_slot_number' => $slot,
                ],
            ];
        });

         $inventoryModel->items()->sync($inventoryItems->all());
    }
}
