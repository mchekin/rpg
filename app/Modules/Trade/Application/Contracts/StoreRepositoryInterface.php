<?php

namespace App\Modules\Trade\Application\Contracts;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Trade\Domain\Store;
use App\Modules\Trade\Domain\StoreId;

interface StoreRepositoryInterface
{
    public function nextIdentity(): StoreId;

    public function add(Store $store): void;

    public function getOne(StoreId $storeId): Store;

    public function forCharacter(CharacterId $characterId): Store;

    public function update(Store $store): void;
}
