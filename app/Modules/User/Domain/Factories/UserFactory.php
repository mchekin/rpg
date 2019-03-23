<?php


namespace App\Modules\User\Domain\Factories;

use App\Factories\GeneratesUuid;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Requests\CreateUserRequest;

class UserFactory
{
    use GeneratesUuid;

    public function create(CreateUserRequest $request): User
    {
        return new User(
            $this->generateUuid(),
            $request->getName(),
            $request->getEmail(),
            $request->getPassword()
        );
    }
}