<?php

namespace App\Modules\Trade\UI\Http\CommandMappers;

use App\Models\User;
use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemId;
use App\Modules\Trade\Application\Commands\BuyItemCommand;
use App\Modules\Trade\Domain\StoreId;
use Illuminate\Http\Request;
use App\Models\User as UserModel;

class BuyItemCommandMapper
{
    public function map(Request $request): BuyItemCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new BuyItemCommand(
            CharacterId::fromString($userModel->character->getId()),
            StoreId::fromString((string)$request->route('store')),
            ItemId::fromString((string)$request->route('item'))
        );
    }
}
