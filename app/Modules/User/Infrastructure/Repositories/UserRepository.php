<?php

namespace App\Modules\User\Infrastructure\Repositories;

use App\Character;
use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\UserInterface;
use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use App\Modules\User\Domain\Models\User;
use App\User as UserModel;

class UserRepository implements UserRepositoryInterface
{
    public function add(User $user)
    {
        /** @var UserModel $userModel */
        $userModel = UserModel::query()->create([
            'name' =>     $user->getName(),
            'email' =>    $user->getEmail(),
            'password' => $user->getPassword()
        ]);

        $user->setModel($userModel);
    }

    public function addCharacter(UserInterface $user, CharacterInterface $character): CharacterInterface
    {
        /** @var $character Character **/
        $character = $user->character()->save($character);

        return $character;
    }
}