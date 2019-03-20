<?php

namespace App;

use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\UserInterface;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * @property Character character
 * @property integer id
 */
class User extends Authenticatable implements UserInterface
{
    use Notifiable;
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the character for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function character()
    {
        return $this->hasOne(Character::class);
    }

    public function hasCharacter(): bool
    {
        return $this->character()->getQuery()->exists();
    }

    public function getId()
    {
        return $this->id;
    }

    public function isCurrentAuthenticatedUser(): bool
    {
        return $this->getId() == Auth::id();
    }

    public function getCharacter(): CharacterInterface
    {
        return $this->character;
    }

    public function hasThisCharacter(CharacterInterface $character): bool
    {
        return $this->character->id === $character->getId();
    }

    public function updateLastUserActivity(): UserInterface
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
