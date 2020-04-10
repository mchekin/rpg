<?php

namespace App\Modules\Trade\UI\Http\CommandMappers;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Trade\Application\Commands\MoveItemToStoreCommand;
use App\Modules\Equipment\Domain\ItemId;
use Illuminate\Http\Request;
use App\User as UserModel;

class MoveItemToStoreCommandMapper
{
    public function map(Request $request): MoveItemToStoreCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new MoveItemToStoreCommand(
            ItemId::fromString((string)$request->route('item')),
            CharacterId::fromString($userModel->character->getId())
        );
    }
}
