<?php


namespace App\Modules\User\Application\Services;

use App\Modules\User\Application\Commands\CreateUserCommand;
use App\Models\User;
use Illuminate\Support\Str;

class UserService
{
    public function create(CreateUserCommand $command): User
    {
        /** @var User $user */
        $user =  User::query()->create([
            'name' => $command->getName(),
            'email' => $command->getEmail(),
            'password' => $command->getPassword(),
            'api_token' => Str::random(60),
        ]);

        return $user;
    }
}
