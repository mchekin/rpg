<?php

namespace App\Modules\Auth\Domain\Entities;

use App\Modules\Character\Domain\Entities\Character;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class User implements \Illuminate\Contracts\Auth\Authenticatable
{
    use \LaravelDoctrine\ORM\Auth\Authenticatable;

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var Character|null */
    private $character;

    /**
     * @var Carbon
     */
    private $createdAt;
    /**
     * @var Carbon
     */
    private $updatedAt;

    public function __construct(
        int $id,
        string $name,
        string $email,
        ?Character $character
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->character = $character;
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }

    public function hasCharacter(): bool
    {
        return isset($this->character);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function hasThisCharacter(Character $character): bool
    {
        return $this->character->getId() === $character->getId();
    }

    public function updateLastUserActivity(): User
    {
        $expiresAt = Carbon::now()->addMinutes(5);

        Cache::put('last-user-activity-' . $this->id, true, $expiresAt);

        return $this;
    }

    public function isOnline(): bool
    {
        return Cache::has('last-user-activity-' . $this->id);
    }
}
