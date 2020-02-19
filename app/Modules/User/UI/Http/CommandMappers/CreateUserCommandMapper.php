<?php


namespace App\Modules\User\UI\Http\CommandMappers;


use App\Modules\User\Application\Commands\CreateUserCommand;

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
