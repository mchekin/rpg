<?php

namespace App\Contracts\Models;

/**
 * @property CharacterInterface character
 */
interface UserInterface
{
    public function hasCharacter(): bool ;

    public function getId();

    public function isCurrentAuthenticatedUser(): bool;

    public function getCharacter(): CharacterInterface;

    public function hasThisCharacter(CharacterInterface $character): bool;

    public function updateLastUserActivity(): UserInterface;

    public function isOnline() :bool;
}