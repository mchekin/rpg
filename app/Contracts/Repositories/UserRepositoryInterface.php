<?php

namespace App\Contracts\Repositories;


use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\UserInterface;

interface UserRepositoryInterface
{
    public function addCharacter(UserInterface $user, CharacterInterface $character): CharacterInterface;
}