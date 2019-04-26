<?php


namespace App\Traits;

trait UsesStringId
{
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}