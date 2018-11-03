<?php

namespace App\Contracts\Repositories;


use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\UserInterface;

interface CharacterRepositoryInterface
{
    public function save(CharacterInterface $character): CharacterInterface;

    public function add(UserInterface $user, CharacterInterface $character): CharacterInterface;
}