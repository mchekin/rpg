<?php declare(strict_types=1);


namespace App\Modules\Trade\Application\Services;

use App\Modules\Equipment\Application\Contracts\InventoryRepositoryInterface;
use App\Modules\Equipment\Application\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Domain\Money;
use App\Modules\Trade\Application\Commands\BuyItemCommand;
use App\Modules\Trade\Application\Commands\SellItemCommand;
use App\Modules\Trade\Application\Contracts\StoreRepositoryInterface;
use App\Modules\Trade\Domain\Exception\SellPriceIsTooHigh;

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
    /**
     * @var ItemPrototypeRepositoryInterface
     */
    private $prototypeRepository;

    public function __construct(
        StoreRepositoryInterface $storeRepository,
        InventoryRepositoryInterface $inventoryRepository,
        ItemPrototypeRepositoryInterface $prototypeRepository
    )
    {
        $this->storeRepository = $storeRepository;
        $this->inventoryRepository = $inventoryRepository;
        $this->prototypeRepository = $prototypeRepository;
    }

    public function buyItem(BuyItemCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getCustomerId());
        $store = $this->storeRepository->getOne($command->getStoreId());

        $item = $store->takeOut($command->getItemId());
        $money = $inventory->takeMoneyOut(new Money($item->getPrice()->getAmount()));
        $inventory->add($item);
        $store->putMoneyIn($money);

        $this->inventoryRepository->update($inventory);
        $this->storeRepository->update($store);
    }

    public function sellItem(SellItemCommand $command): void
    {
        $inventory = $this->inventoryRepository->forCharacter($command->getCustomerId());
        $store = $this->storeRepository->getOne($command->getStoreId());

        $item = $inventory->takeOut($command->getItemId());

        $itemPrototype = $this->prototypeRepository->getOne($item->getPrototypeId());

        $traderBuyPrice = (int)floor($itemPrototype->getPrice()->getAmount() * 0.75);
        $customerSellPrice = $item->getPrice()->getAmount();

        if ($traderBuyPrice < $customerSellPrice) {
            throw new SellPriceIsTooHigh(
                "The store is willing to pay no more than {$traderBuyPrice} coins for {$itemPrototype->getName()}"
            );
        }

        $money = $store->takeMoneyOut(new Money($customerSellPrice));

        $store->add($item);
        $inventory->putMoneyIn($money);

        $this->inventoryRepository->update($inventory);
        $this->storeRepository->update($store);
    }
}
