<?php

namespace App\Modules\User\Infrastructure\Repositories;

use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use App\Modules\User\Domain\Models\User;
use App\User as UserModel;

class UserRepository implements UserRepositoryInterface
{
    public function add(User $user)
    {
        /** @var UserModel $userModel */
        $userModel = UserModel::query()->create([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);

        $user->setUserModel($userModel);
    }
}