<?php


namespace App;


use Ramsey\Uuid\Uuid;

trait UsesUuid
{
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Boot the Model.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($instance) {
            $instance->id = Uuid::uuid4();
        });
    }
}