<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
 * @property int total_hit_points
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

    public function applyAttributeIncrease(string $attribute): Character
    {
        if ($attribute === 'constitution')
        {
            return $this->increaseTotalHitPoints();
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function checkLevelUp(): Character
    {
        while ($this->shouldLevelUp($nextLevel = $this->level->nextLevel())) {

            // update character's level
            $this->level()->associate($nextLevel);

            // add attribute points
            $this->available_attribute_points++;
        }

        return $this;
    }

    protected function shouldLevelUp($nextLevel): bool
    {
        return !is_null($nextLevel) && ($this->xp > $this->level->next_level_xp_threshold);
    }

    protected function increaseTotalHitPoints(): Character
    {
        $this->total_hit_points += 10 + self::throwTwoDices();

        return $this;
    }

    public static function createCharacter(Request $request): Character
    {
        /** @var User $authenticatedUser */
        $authenticatedUser = $request->user();

        /** @var Race $race */
        $race = Race::query()->findOrFail($request->input('race_id'));

        $totalHitPoints = self::calculateHP($race->constitution);

        /** @var Character $character */
        $character = $authenticatedUser->character()->create([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),

            'xp' => 0,
            'level_id' => 1,
            'money' => 0,
            'reputation' => 0,

            'strength' => $race->strength,
            'agility' => $race->agility,
            'constitution' => $race->constitution,
            'intelligence' => $race->intelligence,
            'charisma' => $race->charisma,

            'hit_points' => $totalHitPoints,
            'total_hit_points' => $totalHitPoints,

            'race_id' => $race->id,
            'location_id' => $race->starting_location_id,
        ]);

        return $character;
    }

    protected static function throwTwoDices(): int
    {
        return self::throwOneDice() + self::throwOneDice();
    }

    protected static function throwOneDice(): int
    {
        return rand(1, 6);
    }

    protected static function calculateHP(int $constitution): int
    {
        return $constitution * 10 + self::throwTwoDices();
    }
}
