<?php

namespace App\Modules\Trade\UI\Http\CommandMappers;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Trade\Application\Commands\MoveItemToContainerCommand;
use App\Modules\Equipment\Domain\ItemId;
use Illuminate\Http\Request;
use App\User as UserModel;

class MoveItemToContainerCommandMapper
{
    public function map(Request $request): MoveItemToContainerCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new MoveItemToContainerCommand(
            ItemId::fromString((string)$request->route('item')),
            CharacterId::fromString($userModel->character->getId())
        );
    }
}
