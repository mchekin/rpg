<?php

namespace App\Modules\User\Domain\Contracts;


use App\Modules\User\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function add(User $user);
}