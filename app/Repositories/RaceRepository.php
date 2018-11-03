<?php

namespace App\Repositories;

use App\Contracts\Repositories\RaceRepositoryInterface;
use App\Race;
use Illuminate\Support\Collection;

class RaceRepository implements RaceRepositoryInterface
{
    public function all(): Collection
    {
        return Race::all();
    }
}