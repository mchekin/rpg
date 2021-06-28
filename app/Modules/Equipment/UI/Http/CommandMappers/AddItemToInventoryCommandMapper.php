<?php

namespace App\Modules\Equipment\UI\Http\CommandMappers;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemId;
use App\Modules\Equipment\Application\Commands\AddItemToInventoryCommand;
use Illuminate\Http\Request;
use App\Models\User as UserModel;

class AddItemToInventoryCommandMapper
{
    public function map(Request $request): AddItemToInventoryCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new AddItemToInventoryCommand(
            CharacterId::fromString($userModel->character->getId()),
            (int)$request->input('inventory_slot'),
            ItemId::fromString((string)$request->input('item_id'))
        );
    }
}
