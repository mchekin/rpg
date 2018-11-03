<?php

namespace App\Contracts\Repositories;

use Illuminate\Support\Collection;

interface RaceRepositoryInterface
{
    public function all(): Collection;
}