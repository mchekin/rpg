<?php


namespace App\Modules\User\Domain\Services;

use App\Modules\User\Domain\Commands\CreateUserCommand;
use App\User;

class UserService
{
    public function create(CreateUserCommand $command): User
    {
        /** @var User $user */
        $user =  User::query()->create([
            'name' => $command->getName(),
            'email' => $command->getEmail(),
            'password' => $command->getPassword()
        ]);

        return $user;
    }
}