<?php

namespace App\Contracts\Models;

use App\Character;

interface BattleRoundInterface
{
    public function performTurn(CharacterInterface $executor, CharacterInterface $target): BattleRoundInterface;
}