<?php


namespace App\Modules\Character\Presentation\Http\CommandMappers;

use App\Modules\Character\Domain\Commands\AttackCharacterCommand;
use App\User as UserModel;
use Illuminate\Http\Request;

class AttackCharacterCommandMapper
{
    public function map(Request $request, string $defenderId): AttackCharacterCommand
    {
        /** @var UserModel $authenticatedUser */
        $authenticatedUser = $request->user();

        return new AttackCharacterCommand($authenticatedUser->getCharacter()->getId(), $defenderId);
    }
}