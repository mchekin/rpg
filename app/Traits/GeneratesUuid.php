<?php


namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait GeneratesUuid
{
    protected function generateUuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}