<?php

namespace App\Modules\Equipment\Application\Contracts;

use App\Modules\Equipment\Domain\Item;

interface ItemRepositoryInterface
{
    public function add(Item $item): void;

    public function getOne(string $itemId): Item;

    public function update(Item $item): void;
}
