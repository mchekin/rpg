<?php

namespace App\Modules\User\Domain\Contracts;


use App\Modules\User\Domain\Models\User;

interface UserRepositoryInterface
{
    public function add(User $user);
}