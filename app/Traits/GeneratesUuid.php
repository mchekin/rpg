<?php


namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait GeneratesUuid
{
    protected function generateUuid()
    {
        return Uuid::uuid4();
    }
}