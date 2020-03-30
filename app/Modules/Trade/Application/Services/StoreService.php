<?php declare(strict_types=1);


namespace App\Modules\Trade\Application\Services;

use App\Modules\Trade\Application\Commands\CreateStoreCommand;
use App\Modules\Trade\Application\Contracts\StoreRepositoryInterface;
use App\Modules\Trade\Domain\Store;
use App\Modules\Trade\Domain\StoreType;
use Illuminate\Support\Collection;

class StoreService
{
    /**
     * @var StoreRepositoryInterface
     */
    private $repository;

    public function __construct(StoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateStoreCommand $command):Store
    {
        $id = $this->repository->nextIdentity();

        $store = new Store($id, $command->getCharacterId(), StoreType::sellOnly(), Collection::make());

        $this->repository->add($store);

        return $store;
    }
}
