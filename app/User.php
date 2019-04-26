<?php

namespace App;

use App\Traits\UsesStringId;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * @property Character character
 * @property integer id
 */
class User extends Authenticatable
{
    use Notifiable;
    use UsesStringId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password',
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

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function hasThisCharacter(Character $character): bool
    {
        return $this->character->id === $character->getId();
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
