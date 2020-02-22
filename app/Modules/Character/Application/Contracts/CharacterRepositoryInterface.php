<?php

namespace App\Modules\Character\Application\Contracts;

use App\Modules\Character\Domain\Character;

interface CharacterRepositoryInterface
{
    public function add(Character $character): void;

    public function getOne(string $characterId): Character;

    public function update(Character $character): void;
}
