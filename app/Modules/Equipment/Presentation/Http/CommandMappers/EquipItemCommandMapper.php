<?php

namespace App\Modules\Equipment\Presentation\Http\CommandMappers;

use App\Modules\Equipment\Domain\Commands\EquipItemCommand;
use Illuminate\Http\Request;
use App\User as UserModel;

class EquipItemCommandMapper
{
    public function map(Request $request): EquipItemCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new EquipItemCommand(
            (string)$request->route('item'),
            $userModel->character->getId()
        );
    }
}