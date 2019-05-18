<?php


namespace App\Modules\User\Domain\Services;


use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use App\Modules\User\Domain\Factories\UserFactory;
use App\Modules\User\Domain\Entities\User;
use App\Modules\User\Domain\Commands\CreateUserCommand;

class UserService
{
    /**
     * @var UserFactory
     */
    private $factory;
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    public function __construct(UserFactory $factory, UserRepositoryInterface $repository)
    {
        $this->factory = $factory;
        $this->repository = $repository;
    }

    public function create(CreateUserCommand $command): User
    {
        $user = $this->factory->create($command);

        $this->repository->add($user);

        return $user;
    }
}