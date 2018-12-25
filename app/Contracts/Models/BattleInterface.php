<?php

namespace App\Contracts\Models;

interface BattleInterface
{
    public function execute(): BattleInterface;

    public function getAttacker(): CharacterInterface;

    public function getDefender(): CharacterInterface;

    public function getLocation(): LocationInterface;
}