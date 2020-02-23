<?php

namespace App\Modules\Character\Application\Contracts;

use App\Modules\Character\Domain\Character;
use App\Modules\Character\Domain\CharacterId;

interface CharacterRepositoryInterface
{
    public function nextIdentity(): CharacterId;

    public function add(Character $character): void;

    public function getOne(CharacterId $characterId): Character;

    public function update(Character $character): void;
}
