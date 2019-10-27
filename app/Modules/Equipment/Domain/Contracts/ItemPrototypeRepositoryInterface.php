<?php

namespace App\Modules\Equipment\Domain\Contracts;

use App\Modules\Equipment\Domain\Entities\ItemPrototype;

interface ItemPrototypeRepositoryInterface
{
    public function getOne(string $itemPrototypeId): ItemPrototype;
}