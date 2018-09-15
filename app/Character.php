<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @property User user
 * @property Location location
 * @property integer id
 * @property integer hit_points
 * @property integer xp
 * @property Level level
 * @property integer available_attribute_points
 * @property integer battles_won
 * @property integer battles_lost
 * @property integer strength
 * @property integer agility
 * @property integer location_id
 * @property Race race
 * @property string gender
 */
class Character extends Model
{

    protected $guarded = ['user_id'];/**
 * Get all sent messages.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from_id');
    }

    /**
     * Get all received messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'to_id');
    }

    /**
     * @param Character $companion
     * @param string $content
     *
     * @return $this
     */
    public function sendMessageTo(Character $companion, string $content)
    {
        $this->sentMessages()->create([
            'to_id' => $companion->id,
            'content' => $content,
        ]);

        return $this;
    }



    /**
     * Get the user of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Get the user of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Get the current location of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return bool
     */
    public function isYou()
    {
        return $this->isPlayerCharacter() && $this->user->id == Auth::id();
    }

    /**
     * Check if the character is a Player Character
     *
     * @return bool
     */
    public function isPlayerCharacter()
    {
        return !is_null($this->user);
    }

    /**
     * Check if the character is an Non Player Character
     *
     * @return bool
     */
    public function isNPC()
    {
        return is_null($this->user);
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->race->getImageByGender($this->gender);
    }

    /**
     * @return string
     */
    public function getRaceName()
    {
        return $this->race->name;
    }

    /**
     * @return integer
     */
    public function getLevelNumber()
    {
        return $this->level->id;
    }

    /**
     * @return integer
     */
    public function getNextLevelXp()
    {
        return $this->level->next_level_xp_threshold;
    }

    /**
     * @return string
     */
    public function getLocationName()
    {
        return $this->location->name;
    }

    /**
     * @param Character $defender
     * @return Battle
     */
    public function attack(Character $defender)
    {
        return DB::transaction(function () use ($defender) {

            /** @var Battle $battle */
            $battle = Battle::query()->create([
                'attacker_id' => $this->id,
                'defender_id' => $defender->id,
                'location_id' => $defender->location->id,
            ]);

            return $battle->execute();
        });
    }

    /**
     * @return $this
     */
    public function checkLevelUp()
    {
        while ($this->shouldLevelUp($nextLevel = $this->level->nextLevel())) {

            // update character's level
            $this->level()->associate($nextLevel);

            // add attribute points
            $this->available_attribute_points++;
        }

        return $this;
    }

    /**
     * @param Level $nextLevel
     * @return bool
     */
    protected function shouldLevelUp($nextLevel): bool
    {
        return !is_null($nextLevel) && ($this->xp > $this->level->next_level_xp_threshold);
    }

}
