<?php

namespace App\Modules\Equipment\UI\Http\CommandMappers;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemId;
use App\Modules\Equipment\Application\Commands\EquipItemCommand;
use Illuminate\Http\Request;
use App\User as UserModel;

class EquipItemCommandMapper
{
    public function map(Request $request): EquipItemCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new EquipItemCommand(
            ItemId::fromString((string)$request->route('item')),
            CharacterId::fromString($userModel->character->getId())
        );
    }
}
