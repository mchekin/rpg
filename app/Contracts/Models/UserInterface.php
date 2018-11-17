<?php

namespace App\Contracts\Models;

/**
 * @property CharacterInterface character
 * @property integer id
 */
interface UserInterface
{
    public function hasCharacter(): bool ;

    public function getId(): int;

    public function isCurrentAuthenticatedUser(): bool;

    public function getCharacter(): CharacterInterface;
}