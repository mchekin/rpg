<?php declare(strict_types=1);


namespace App\Modules\Trade\Application\Services;

use App\Modules\Equipment\Domain\Money;
use App\Modules\Trade\Application\Commands\CreateStoreCommand;
use App\Modules\Trade\Application\Contracts\StoreRepositoryInterface;
use App\Modules\Trade\Domain\Store;
use App\Modules\Trade\Domain\StoreType;
use Illuminate\Support\Collection;

class CreateStoreService
{
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function create(CreateStoreCommand $command): Store
    {
        $id = $this->storeRepository->nextIdentity();

        $store = new Store($id, $command->getCharacterId(), StoreType::sellOnly(), Collection::make(), new Money(0));

        $this->storeRepository->add($store);

        return $store;
    }
}
