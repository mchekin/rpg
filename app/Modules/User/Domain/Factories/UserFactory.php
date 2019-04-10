<?php


namespace App\Modules\User\Domain\Factories;

use App\Traits\GeneratesUuid;
use App\Modules\User\Domain\Entities\User;
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