<?php

namespace App\Contracts\Models;

/**
 * @property CharacterInterface character
 * @property integer id
 */
interface UserInterface
{
    public function hasCharacter(): bool ;
}