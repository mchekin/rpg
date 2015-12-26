<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * Get the neighboring location to the north of the current location
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locationToTheNorth()
    {
        return $this->belongsTo('App\Location', 'north_location_id');
    }
    /**
     * Get the neighboring location to the east of the current location
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locationToTheEast()
    {
        return $this->belongsTo('App\Location', 'east_location_id');
    }
    /**
     * Get the neighboring location to the south of the current location
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locationToTheSouth()
    {
        return $this->belongsTo('App\Location', 'south_location_id');
    }
    /**
     * Get the neighboring location to the west of the current location
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locationToTheWest()
    {
        return $this->belongsTo('App\Location', 'west_location_id');
    }
}
