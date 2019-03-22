<?php


namespace App\Modules\User\Domain\Models;

use App\Modules\Character\Domain\Models\Character;
use App\User as UserModel;

class User
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;
    /**
     * @var UserModel
     */
    private $userModel;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function hasCharacter(): bool
    {
        // TODO: Implement hasCharacter() method.
    }

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function isCurrentAuthenticatedUser(): bool
    {
        // TODO: Implement isCurrentAuthenticatedUser() method.
    }

    public function getCharacter(): Character
    {
        // TODO: Implement getCharacter() method.
    }

    public function hasThisCharacter(Character $character): bool
    {
        // TODO: Implement hasThisCharacter() method.
    }

    public function updateLastUserActivity(): User
    {
        // TODO: Implement updateLastUserActivity() method.
    }

    public function isOnline(): bool
    {
        // TODO: Implement isOnline() method.
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setModel(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @return UserModel
     */
    public function getUserModel(): UserModel
    {
        return $this->userModel;
    }
}