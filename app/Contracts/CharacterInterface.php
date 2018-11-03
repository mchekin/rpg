<?php

namespace App\Contracts;
use App\Battle;
use App\Character;
use App\Level;
use App\Location;
use App\Race;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;


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
interface CharacterInterface
{
    /**
     * Get the user of the character
     *
     * @return BelongsTo
     */
    public function level();

    /**
     * Get the user of the character
     *
     * @return BelongsTo
     */
    public function user();

    /**
     * Get the user of the character
     *
     * @return BelongsTo
     */
    public function race();

    /**
     * Get the current location of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location();

    /**
     * Get all sent messages.
     *
     * @return HasMany
     */
    public function sentMessages();

    /**
     * Get all received messages.
     *
     * @return HasMany
     */
    public function receivedMessages();

    /**
     * @param Character $companion
     * @param string $content
     *
     * @return $this
     */
    public function sendMessageTo(Character $companion, string $content): CharacterInterface;

    public function isYou(): bool ;

    public function isPlayerCharacter(): bool;

    public function isNPC(): bool;

    public function getImage(): string;

    public function getRaceName(): string;

    public function getLevelNumber():int;

    public function getNextLevelXp(): int;

    public function getLocationName(): string;

    public function attack(CharacterInterface $defender): Battle;

    public function applyAttributeIncrease(string $attribute): CharacterInterface;

    public function checkLevelUp(): CharacterInterface;

    public static function createCharacter(Request $request): CharacterInterface;
}