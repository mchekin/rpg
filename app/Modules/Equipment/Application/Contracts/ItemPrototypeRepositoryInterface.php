<?php

namespace App\Modules\Equipment\Application\Contracts;

use App\Modules\Equipment\Domain\Entities\ItemPrototype;

interface ItemPrototypeRepositoryInterface
{
    public function getOne(string $itemPrototypeId): ItemPrototype;
}
