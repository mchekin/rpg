<?php

namespace App\Contracts;


interface CharacterRepositoryInterface
{
    public function save(CharacterInterface $character): CharacterInterface;
}