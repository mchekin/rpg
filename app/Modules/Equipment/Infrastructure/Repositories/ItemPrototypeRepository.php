<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\Modules\Equipment\Domain\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\ItemPrototype;

class ItemPrototypeRepository implements ItemPrototypeRepositoryInterface
{
    public function add(ItemPrototype $item)
    {
        // TODO: Implement add() method.
    }

    public function getOne(string $itemId): ItemPrototype
    {
        // TODO: Implement getOne() method.
    }

    public function update(ItemPrototype $item)
    {
        // TODO: Implement update() method.
    }
}