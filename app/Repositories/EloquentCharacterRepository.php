<?php

namespace App\Repositories;


use App\Character;
use App\Contracts\CharacterInterface;
use App\Contracts\CharacterRepositoryInterface;

class EloquentCharacterRepository implements CharacterRepositoryInterface
{
    public function save(CharacterInterface $character): CharacterInterface
    {
        /** @var $character Character **/
        $character->save();

        return $character;
    }
}