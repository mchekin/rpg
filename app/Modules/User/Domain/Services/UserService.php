<?php


namespace App\Modules\User\Domain\Services;


use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use App\Modules\User\Domain\Factories\UserFactory;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Requests\CreateUserRequest;

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

    public function create(CreateUserRequest $request): User
    {
        $user = $this->factory->create($request);

        $this->repository->add($user);

        return $user;
    }
}