<?php

namespace App;

use App\Contracts\Models\UserInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * @property Character character
 * @property integer id
 */
class User extends Authenticatable implements UserInterface
{
    use Notifiable;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function isCurrentAuthenticatedUser(): bool
    {
        return $this->getId() == Auth::id();
    }
}
