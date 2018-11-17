<?php

namespace App\Contracts\Models;


/**
 * @property integer id
 * @property string name
 */
interface LocationInterface
{

    public function adjacent($type);

    public function addAdjacentLocation(LocationInterface $adjacent, $direction): LocationInterface;

    /**
     * @param LocationInterface $adjacent
     */
    public function removeAdjacentLocation(LocationInterface $adjacent);

    public function getName(): string ;
}