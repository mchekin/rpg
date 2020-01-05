<?php

namespace App\Modules\Auth\Domain\Contracts;

use App\Modules\Auth\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function getOne(int $id): User;
}
