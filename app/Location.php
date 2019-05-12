<?php

namespace App;

use App\Traits\UsesStringId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string id
 * @property string name
 */
class Location extends Model
{
    use UsesStringId;

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

    public function adjacent($type)
    {
        return $this->adjacentLocations()->wherePivot('direction', $type)->first();
    }

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

    public function removeAdjacentLocation(Location $adjacent)
    {
        $this->adjacentLocations()->detach($adjacent);   // remove friend
        $adjacent->adjacentLocations()->detach($this);  // remove yourself, too
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isAdjacentLocation(Location $location): bool
    {
        return (bool)$this->adjacentLocations()->where('id', $location->getId())->first();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
