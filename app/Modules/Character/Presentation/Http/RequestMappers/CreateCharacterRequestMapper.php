<?php


namespace App\Modules\Character\Presentation\Http\RequestMappers;

use App\Modules\Character\Domain\Requests\CreateCharacterRequest;
use Illuminate\Http\Request;
use App\User as UserModel;

class CreateCharacterRequestMapper
{
    public function map(Request $request): CreateCharacterRequest
    {
        /** @var UserModel $userModel */
        $userModel = $request->user();

        return new CreateCharacterRequest(
            $request->input('name'),
            $request->input('gender'),
            $request->input('race_id'),
            $userModel->getId()
        );
    }
}