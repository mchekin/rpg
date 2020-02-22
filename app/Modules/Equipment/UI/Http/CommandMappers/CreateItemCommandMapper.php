<?php

namespace App\Modules\Equipment\UI\Http\CommandMappers;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Application\Commands\CreateItemCommand;
use Illuminate\Http\Request;
use App\User as UserModel;

class CreateItemCommandMapper
{
    public function map(Request $request): CreateItemCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new CreateItemCommand(
            $request->input('prototype_item_id'),
            CharacterId::fromString($userModel->character->getId())
        );
    }
}
