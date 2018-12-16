<?php

namespace App\Contracts\Models;

interface ImageInterface
{
    public function getId(): int;

    public function getFilePathFull(): string;

    public function getFilePathSmall(): string;

    public function getFilePathIcon(): string;
}