<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    static protected $directions = [
        'north' => 'south',
        'east' => 'west',
    ];

    static public function getDirections()
    {
        return array_merge(array_keys(Location::$directions), array_values(Location::$directions));
    }

    static protected function getAppositeDirection($direction)
    {
        if (array_key_exists ($direction, self::$directions)) {
            return self::$directions[$direction];
        }

        if (in_array($direction, self::$directions)) {
            return array_search($direction, self::$directions);
        }

        throw new \InvalidArgumentException('Invalid direction: '.$direction);
    }

    static protected function isValidDirection($direction)
    {
        return array_key_exists ($direction, self::$directions) || in_array($direction, self::$directions);
    }

    /**
     * Get the characters at the location.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->hasMany('App\Character');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function adjacentLocations()
    {
        return $this->belongsToMany('App\Location', 'adjacent_location', 'location_id', 'adjacent_location_id');
    }

    /**
     * Get the neighboring location to the north of the current location
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
