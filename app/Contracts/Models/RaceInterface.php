<?php

namespace App\Contracts\Models;

interface RaceInterface
{
    public function getImageByGender(string $gender): string;

    public function getStartingLocationId(): int;

    public function getId(): int;

    public function getStrength(): int;

    public function getAgility(): int;

    public function getConstitution(): int;

    public function getIntelligence(): int;

    public function getCharisma(): int;

    public function getName(): string;
}