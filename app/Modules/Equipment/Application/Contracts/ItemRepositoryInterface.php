<?php

namespace App\Modules\Equipment\Application\Contracts;

use App\Modules\Equipment\Domain\ItemId;
use App\Modules\Equipment\Domain\Item;

interface ItemRepositoryInterface
{
    public function nextIdentity(): ItemId;

    public function add(Item $item): void;

    public function getOne(ItemId $itemId): Item;

    public function update(Item $item): void;
}
