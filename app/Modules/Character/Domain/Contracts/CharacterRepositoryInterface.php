<?php

namespace App\Modules\Character\Domain\Contracts;

use App\Modules\Character\Domain\Models\Character;

interface CharacterRepositoryInterface
{
    public function add(Character $character);

    public function getOne(string $characterId): Character;
}