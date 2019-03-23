<?php


namespace App\Factories;

use Ramsey\Uuid\Uuid;

trait GeneratesUuid
{
    public function generateUuid()
    {
        return Uuid::uuid4();
    }
}