<?php declare(strict_types=1);


namespace App\Modules\Trade\Application\Services;

use App\Modules\Equipment\Application\Contracts\InventoryRepositoryInterface;
use App\Modules\Equipment\Domain\Money;
use App\Modules\Trade\Application\Commands\BuyItemCommand;
use App\Modules\Trade\Application\Contracts\StoreRepositoryInterface;

class TradeService
{
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var InventoryRepositoryInterface
     */
    private $inventoryRepository;

    public function __construct(
        StoreRepositoryInterface $storeRepository,
        InventoryRepositoryInterface $inventoryRepository
    )
    {
        $this->storeRepository = $storeRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function buyItem(BuyItemCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getBuyerId());
        $store = $this->storeRepository->getOne($command->getStoreId());

        $item = $store->takeOut($command->getItemId());
        $money = $inventory->takeMoneyOut(new Money($item->getPrice()->getAmount()));
        $inventory->add($item);
        $store->putMoneyIn($money);

        $this->inventoryRepository->update($inventory);
        $this->storeRepository->update($store);
    }
}
