<?php


namespace App\Modules\Character\UI\Http\CommandMappers;

use App\Modules\Character\Application\Commands\AttackCharacterCommand;
use App\Modules\Character\Domain\CharacterId;
use App\User as UserModel;
use Illuminate\Http\Request;

class AttackCharacterCommandMapper
{
    public function map(Request $request, string $defenderId): AttackCharacterCommand
    {
        /** @var UserModel $authenticatedUser */
        $userModel = $request->user();

        return new AttackCharacterCommand(
            CharacterId::fromString($userModel->character->getId()),
            CharacterId::fromString($defenderId)
        );
    }
}
