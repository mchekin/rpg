<?php

namespace App\Modules\Trade\UI\Http\CommandMappers;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemPrice;
use App\Modules\Trade\Application\Commands\ChangeItemPriceCommand;
use App\Modules\Equipment\Domain\ItemId;
use Illuminate\Http\Request;
use App\User as UserModel;

class ChangeItemPriceCommandMapper
{
    public function map(Request $request): ChangeItemPriceCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new ChangeItemPriceCommand(
            ItemId::fromString((string)$request->route('item')),
            ItemPrice::ofAmount((int)$request->post('price')),
            CharacterId::fromString($userModel->character->getId())
        );
    }
}
