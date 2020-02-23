<?php

namespace App\Modules\Equipment\Application\Contracts;

use App\Modules\Equipment\Domain\ItemPrototypeId;
use App\Modules\Equipment\Domain\ItemPrototype;

interface ItemPrototypeRepositoryInterface
{
    public function nextIdentity(): ItemPrototypeId;

    public function getOne(ItemPrototypeId $itemPrototypeId): ItemPrototype;
}
