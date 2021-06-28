<?php


namespace App\Modules\User\Application\Services;

use App\Modules\User\Application\Commands\CreateUserCommand;
use App\Models\User;

class UserService
{
    public function create(CreateUserCommand $command): User
    {
        /** @var User $user */
        $user =  User::query()->create([
            'name' => $command->getName(),
            'email' => $command->getEmail(),
            'password' => $command->getPassword(),
        ]);

        return $user;
    }
}
