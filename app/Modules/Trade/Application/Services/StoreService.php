<?php declare(strict_types=1);


namespace App\Modules\Trade\Application\Services;

use App\Modules\Equipment\Application\Contracts\InventoryRepositoryInterface;
use App\Modules\Equipment\Domain\Money;
use App\Modules\Trade\Application\Commands\CreateStoreCommand;
use App\Modules\Trade\Application\Commands\MoveItemToContainerCommand;
use App\Modules\Trade\Application\Commands\MoveMoneyToContainerCommand;
use App\Modules\Trade\Application\Contracts\StoreRepositoryInterface;
use App\Modules\Trade\Domain\Store;
use App\Modules\Trade\Domain\StoreType;
use Illuminate\Support\Collection;

class StoreService
{
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var InventoryRepositoryInterface
     */
    private $inventoryRepository;

    public function __construct(StoreRepositoryInterface $storeRepository, InventoryRepositoryInterface $inventoryRepository)
    {
        $this->storeRepository = $storeRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function create(CreateStoreCommand $command): Store
    {
        $id = $this->storeRepository->nextIdentity();

        $store = new Store($id, $command->getCharacterId(), StoreType::sellOnly(), Collection::make(), new Money(0));

        $this->storeRepository->add($store);

        return $store;
    }

    public function moveItemToStore(MoveItemToContainerCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getCharacterId());
        $store = $this->storeRepository->forCharacter($command->getCharacterId());

        $item = $inventory->takeOut($command->getItemId());
        $store->add($item);

        $this->inventoryRepository->update($inventory);
        $this->storeRepository->update($store);
    }

    public function moveItemToInventory(MoveItemToContainerCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getCharacterId());
        $store = $this->storeRepository->forCharacter($command->getCharacterId());

        $item = $store->takeOut($command->getItemId());
        $inventory->add($item);

        $this->inventoryRepository->update($inventory);
        $this->storeRepository->update($store);
    }

    public function moveMoneyToStore(MoveMoneyToContainerCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getCharacterId());
        $store = $this->storeRepository->forCharacter($command->getCharacterId());

        $money = $inventory->takeMoneyOut($command->getMoney());
        $store->putMoneyIn($money);

        $this->inventoryRepository->update($inventory);
        $this->storeRepository->update($store);
    }

    public function moveMoneyToInventory(MoveMoneyToContainerCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getCharacterId());
        $store = $this->storeRepository->forCharacter($command->getCharacterId());

        $money = $store->takeMoneyOut($command->getMoney());
        $inventory->putMoneyIn($money);

        $this->inventoryRepository->update($inventory);
        $this->storeRepository->update($store);
    }
}
