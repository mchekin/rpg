<?php

namespace App\Modules\Equipment\Presentation\Http\CommandMappers;

use App\Modules\Character\Domain\Commands\AddItemToInventoryCommand;
use Illuminate\Http\Request;
use App\User as UserModel;

class AddItemToInventoryCommandMapper
{
    public function map(Request $request): AddItemToInventoryCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new AddItemToInventoryCommand(
            $userModel->character->getId(),
            (int)$request->input('inventory_slot'),
            (string)$request->input('item_id')
        );
    }
}