<?php


namespace App\Modules\User\Presentation\Http\RequestMappers;


use App\Modules\User\Domain\Requests\CreateUserRequest;

class CreateUserRequestMapper
{
    public function map(array $data): CreateUserRequest
    {
        return new CreateUserRequest(
            $data['name'],
            $data['email'],
            bcrypt($data['password'])
        );
    }
}