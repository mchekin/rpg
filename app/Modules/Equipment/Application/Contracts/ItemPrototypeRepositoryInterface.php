<?php

namespace App\Modules\Equipment\Application\Contracts;

use App\Modules\Equipment\Domain\ItemPrototype;

interface ItemPrototypeRepositoryInterface
{
    public function getOne(string $itemPrototypeId): ItemPrototype;
}
