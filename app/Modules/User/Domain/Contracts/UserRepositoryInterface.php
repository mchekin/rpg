<?php

namespace App\Modules\User\Domain\Contracts;


use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\UserInterface;
use App\Modules\User\Domain\Models\User;

interface UserRepositoryInterface
{
    public function add(User $user);

    public function addCharacter(UserInterface $user, CharacterInterface $character): CharacterInterface;
}