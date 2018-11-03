<?php

namespace App\Contracts\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property CharacterInterface character
 * @property integer id
 */
interface UserInterface
{
    /**
     * Get the character for the user.
     *
     * @return HasMany
     */
    public function character();

    public function hasCharacter(): bool ;
}