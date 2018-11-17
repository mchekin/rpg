<?php

namespace App\Contracts\Repositories;

use App\Contracts\Models\RaceInterface;
use Illuminate\Support\Collection;

interface RaceRepositoryInterface
{
    public function all(): Collection;

    public function findOrFail(int $id): RaceInterface;
}