<?php

namespace App\Modules\Trade\UI\Http\CommandMappers;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemId;
use App\Modules\Trade\Application\Commands\SellItemCommand;
use App\Modules\Trade\Domain\StoreId;
use Illuminate\Http\Request;
use App\User as UserModel;

class SellItemCommandMapper
{
    public function map(Request $request): SellItemCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new SellItemCommand(
            CharacterId::fromString($userModel->character->getId()),
            StoreId::fromString((string)$request->route('store')),
            ItemId::fromString((string)$request->route('item'))
        );
    }
}
