<?php

namespace App\Contracts\Models;

interface LocationInterface
{
    public function adjacent($type);

    public function addAdjacentLocation(LocationInterface $adjacent, $direction);

    public function removeAdjacentLocation(LocationInterface $adjacent);

    public function getName(): string ;

    public function isAdjacentLocation(LocationInterface $location): bool;

    public function getId(): int;
}