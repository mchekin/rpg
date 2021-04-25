<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * @property Character character
 * @property integer id
 */
class User extends \TCG\Voyager\Models\User
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function character(): HasOne
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