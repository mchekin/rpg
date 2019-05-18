<?php


namespace App\Modules\User\Domain\Factories;

use App\Traits\GeneratesUuid;
use App\Modules\User\Domain\Entities\User;
use App\Modules\User\Domain\Commands\CreateUserCommand;

class UserFactory
{
    use GeneratesUuid;

    public function create(CreateUserCommand $command): User
    {
        return new User(
            $this->generateUuid(),
            $command->getName(),
            $command->getEmail(),
            $command->getPassword()
        );
    }
}