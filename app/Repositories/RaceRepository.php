<?php

namespace App\Repositories;

use App\Contracts\Models\RaceInterface;
use App\Contracts\Repositories\RaceRepositoryInterface;
use App\Race;
use Illuminate\Support\Collection;

class RaceRepository implements RaceRepositoryInterface
{
    public function all(): Collection
    {
        return Race::all();
    }

    public function findOrFail(int $id): RaceInterface
    {
        /** @var RaceInterface $race */
        $race = Race::query()->findOrFail($id);

        return $race;
    }
}