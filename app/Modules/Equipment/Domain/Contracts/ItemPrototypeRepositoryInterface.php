<?php

namespace App\Modules\Equipment\Domain\Contracts;

use App\Modules\Equipment\Domain\Entities\ItemPrototype;

interface ItemPrototypeRepositoryInterface
{
    public function add(ItemPrototype $item);

    public function getOne(string $itemId): ItemPrototype;

    public function update(ItemPrototype $item);
}