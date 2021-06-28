<?php

namespace App\Modules\Trade\UI\Http\CommandMappers;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\Money;
use App\Modules\Trade\Application\Commands\MoveMoneyToContainerCommand;
use Illuminate\Http\Request;
use App\Models\User as UserModel;

class MoveMoneyToContainerCommandMapper
{
    public function map(Request $request): MoveMoneyToContainerCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new MoveMoneyToContainerCommand(
            new Money((int)$request->post('money_amount', 0)),
            CharacterId::fromString($userModel->character->getId())
        );
    }
}
