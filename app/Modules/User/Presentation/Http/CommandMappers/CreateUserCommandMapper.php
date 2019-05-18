<?php


namespace App\Modules\User\Presentation\Http\CommandMappers;


use App\Modules\User\Domain\Commands\CreateUserCommand;

class CreateUserCommandMapper
{
    public function map(array $data): CreateUserCommand
    {
        return new CreateUserCommand(
            $data['name'],
            $data['email'],
            bcrypt($data['password'])
        );
    }
}