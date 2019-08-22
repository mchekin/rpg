<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\Modules\Equipment\Domain\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\Item;

class ItemRepository implements ItemRepositoryInterface
{
    public function add(Item $item)
    {
        // TODO: Implement add() method.
    }

    public function getOne(string $itemId): Item
    {
        // TODO: Implement getOne() method.
    }

    public function update(Item $item)
    {
        // TODO: Implement update() method.
    }
}