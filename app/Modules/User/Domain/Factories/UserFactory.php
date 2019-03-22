<?php


namespace App\Modules\User\Domain\Factories;

use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Requests\CreateUserRequest;

class UserFactory
{
    public function create(CreateUserRequest $request): User
    {
        return new User(
            $request->getName(),
            $request->getEmail(),
            $request->getPassword()
        );
    }
}