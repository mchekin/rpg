<?php

namespace App\Contracts\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property integer id
 * @property string name
 */
interface LocationInterface
{
    /**
     * Get the characters at the location.
     *
     * @return HasMany
     */
    public function characters();

    /**
     * @return BelongsToMany
     */
    public function adjacentLocations();

    /**
     * Get the adjacent location to the north of the current location.
     *
     * @param $type
     * @return mixed
     */
    public function adjacent($type);

    /**
     * @param LocationInterface $adjacent
     * @param $direction
     */
    public function addAdjacentLocation(LocationInterface $adjacent, $direction);

    /**
     * @param LocationInterface $adjacent
     */
    public function removeAdjacentLocation(LocationInterface $adjacent);
}