<?php

namespace App\Modules\Equipment\Application\Contracts;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\Inventory;
use App\Modules\Equipment\Domain\InventoryId;

interface InventoryRepositoryInterface
{
    public function nextIdentity(): InventoryId;

    public function add(Inventory $inventory): void;

    public function forCharacter(CharacterId $characterId): Inventory;

    public function update(Inventory $inventory): void;
}
