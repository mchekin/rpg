<?php

namespace App\Contracts\Models;


/**
 * @property integer strength
 * @property integer agility
 * @property integer constitution
 * @property integer intelligence
 * @property integer charisma
 * @property integer starting_location_id
 * @property integer id
 * @property string name
 */
interface RaceInterface
{
    /**
     * Get the characters for the race.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters();

    /**
     * @param $gender
     *
     * @return string
     */
    public function getImageByGender($gender);
}