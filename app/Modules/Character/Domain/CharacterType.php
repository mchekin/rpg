<?php


namespace App\Modules\Character\Domain;

use InvalidArgumentException;

class CharacterType
{
    public const PLAYER = 'player';
    public const MERCHANT = 'merchant';
    public const CIVILIAN = 'civilian';
    public const MONSTER = 'monster';

    public const TYPES = [
        self::PLAYER,
        self::MERCHANT,
        self::CIVILIAN,
        self::MONSTER,
    ];

    private $value;

    public function __construct(string $value)
    {
        if (!in_array($value, self::TYPES, true)) {
            throw new InvalidArgumentException("$value is not a valid Character Type");
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isMerchant(): bool
    {
        return $this->value === self::MERCHANT;
    }
}
