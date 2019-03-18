<?php

namespace App\Contracts\Models;

interface BattleRoundInterface
{
    public function performTurn(CharacterInterface $executor, CharacterInterface $target): BattleRoundInterface;
}