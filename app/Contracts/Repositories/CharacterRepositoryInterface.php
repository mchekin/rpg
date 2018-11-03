<?php

namespace App\Contracts\Repositories;


use App\Contracts\Models\CharacterInterface;

interface CharacterRepositoryInterface
{
    public function save(CharacterInterface $character): CharacterInterface;
}