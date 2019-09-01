<?php

namespace App\Modules\Equipment\Domain\Contracts;

use App\Modules\Equipment\Domain\Entities\Item;

interface ItemRepositoryInterface
{
    public function add(Item $item);

    public function getOne(string $itemId): Item;
}