<?php

namespace App\Contracts\Models;


/**
 * @property integer id
 * @property string name
 */
interface LocationInterface
{
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