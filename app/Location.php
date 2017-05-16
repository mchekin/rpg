<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer id
 */
class Location extends Model
{
    static protected $oppositeDirections = [
        'north' => 'south',
        'east' => 'west',
    ];

    /**
     * Getting all possible movement directions.
     *
     * @return array
     */
    static public function getDirections()
    {
        return array_merge(array_keys(Location::$oppositeDirections), array_values(Location::$oppositeDirections));
    }

    /**
     * Getting the opposite direction
     *
     * @param $direction
     *
     * @return mixed
     */
    static protected function getAppositeDirection($direction)
    {
        if (array_key_exists ($direction, self::$oppositeDirections)) {
            return self::$oppositeDirections[$direction];
        }

        if (in_array($direction, self::$oppositeDirections)) {
            return array_search($direction, self::$oppositeDirections);
        }

        throw new \InvalidArgumentException('Invalid direction: '.$direction);
    }

    /**
     * @param $direction
     *
     * @return bool
     */
    static protected function isValidDirection($direction)
    {
        return array_key_exists ($direction, self::$oppositeDirections) || in_array($direction, self::$oppositeDirections);
    }

    /**
     * Get the characters at the location.
     *
     * @return HasMany
     */
    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    /**
     * @return BelongsToMany
     */
    public function adjacentLocations()
    {
        return $this->belongsToMany(Location::class, 'adjacent_location', 'location_id', 'adjacent_location_id');
    }

    /**
     * Get the adjacent location to the north of the current location.
     *
     * @param $type
     * @return mixed
     */
    public function adjacent($type)
    {
        return $this->adjacentLocations()->wherePivot('direction', $type)->first();
    }

    /** TODO: maybe for later use */
    /**
     * @param Location $adjacent
     * @param $direction
     */
    public function addAdjacentLocation(Location $adjacent, $direction)
    {
        if (!self::isValidDirection($direction)) {
            throw new \InvalidArgumentException('Invalid adjacent direction type: '.$direction);
        }

        $this->adjacentLocations()->attach($adjacent, [
            'direction' => $direction,
            "created_at"            => Carbon::now(),
            "updated_at"            => Carbon::now(),
        ]); // add adjacent

        $adjacent->adjacentLocations()->attach($this, [
            'direction' => self::getAppositeDirection($direction),
            "created_at"            => Carbon::now(),
            "updated_at"            => Carbon::now(),
        ]); // add yourself, too
    }

    /**
     * @param Location $adjacent
     */
    public function removeAdjacentLocation(Location $adjacent)
    {
        $this->adjacentLocations()->detach($adjacent);   // remove friend
        $adjacent->adjacentLocations()->detach($this);  // remove yourself, too
    }
}
