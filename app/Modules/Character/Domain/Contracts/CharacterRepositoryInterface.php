<?php

namespace App\Modules\Character\Domain\Contracts;

use App\Modules\Character\Domain\Entities\Character;

interface CharacterRepositoryInterface
{
    public function add(Character $character);

    public function getOne(string $characterId): Character;

    public function update(Character $character);
}