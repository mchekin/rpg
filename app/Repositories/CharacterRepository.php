<?php

namespace App\Repositories;

use App\Character;
use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\UserInterface;
use App\Contracts\Repositories\CharacterRepositoryInterface;

class CharacterRepository implements CharacterRepositoryInterface
{
    public function save(CharacterInterface $character): CharacterInterface
    {
        /** @var $character Character **/
        $character->save();

        return $character;
    }

    public function add(UserInterface $user, CharacterInterface $character): CharacterInterface
    {
        /** @var $character Character **/
        $character = $user->character()->save($character);

        return $character;
    }
}