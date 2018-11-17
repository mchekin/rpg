<?php

namespace App\Repositories;

use App\Character;
use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\UserInterface;
use App\Contracts\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function addCharacter(UserInterface $user, CharacterInterface $character): CharacterInterface
    {
        /** @var $character Character **/
        $character = $user->character()->save($character);

        return $character;
    }
}