<?php


namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait GeneratesUuid
{
    protected function generateUuid(): string
    {
        return (string) Uuid::uuid4();
    }
}