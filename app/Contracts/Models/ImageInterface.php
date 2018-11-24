<?php

namespace App\Contracts\Models;

interface ImageInterface
{
    public function getId(): int;

    public function getFilename(): string;
}