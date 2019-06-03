<?php


namespace App\Modules\Character\Presentation\Http\CommandMappers;

use App\Modules\Character\Domain\Commands\CreateCharacterCommand;
use Illuminate\Http\Request;
use App\User as UserModel;

class CreateCharacterCommandMapper
{
    public function map(Request $request): CreateCharacterCommand
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new CreateCharacterCommand(
            $request->input('name'),
            $request->input('gender'),
            $request->input('race_id'),
            $userModel->getId()
        );
    }
}