<?php

namespace App\Contracts\Models;
use Illuminate\Http\Request;

interface CharacterInterface
{

    public static function createCharacter(Request $request, RaceInterface $race): CharacterInterface;

    public function getId();

    public function getStrength():int;

    public function getAgility():int;

    public function getConstitution():int;

    public function sendMessageTo(CharacterInterface $companion, string $content): CharacterInterface;

    public function isYou(): bool ;

    public function isPlayerCharacter(): bool;

    public function isNPC(): bool;

    public function getImage(): string;

    public function getRaceName(): string;

    public function getLevelNumber():int;

    public function getNextLevelXp(): int;

    public function getLocationName(): string;

    public function attack(CharacterInterface $defender): BattleInterface;

    public function applyAttributeIncrease(string $attribute): CharacterInterface;

    public function isAlive(): bool;

    public function incrementWonBattles(): CharacterInterface;

    public function incrementLostBattles(): CharacterInterface;

    public function addXp(int $xp): CharacterInterface;

    public function applyDamage($damageDone): CharacterInterface;

    public function getLocationId(): int;
}