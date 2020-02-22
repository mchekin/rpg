<?php

namespace App\Modules\Equipment\Domain;

use InvalidArgumentException;

class ItemType
{
    public const MISCELLANEOUS = 'miscellaneous';
    public const HEAD_GEAR = 'head_gear';
    public const BODY_ARMOR = 'body_armor';
    public const MAIN_HAND = 'main_hand';
    public const OFF_HAND = 'off_hand';

    public const TYPES = [
        self::MISCELLANEOUS,
        self::HEAD_GEAR,
        self::BODY_ARMOR,
        self::MAIN_HAND,
        self::OFF_HAND,
    ];

    /**
     * @var string
     */
    private $type;

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function ofType(string $type): ItemType
    {
        if (!in_array($type, self::TYPES, true)) {
            throw new InvalidArgumentException("$type is not a valid Item Type");
        }

        return new self($type);
    }

    public static function headGear(): ItemType
    {
        return new self(self::HEAD_GEAR);
    }

    public static function bodyArmor(): ItemType
    {
        return new self(self::BODY_ARMOR);
    }

    public static function mainHand(): ItemType
    {
        return new self(self::MAIN_HAND);
    }

    public static function offHand(): ItemType
    {
        return new self(self::OFF_HAND);
    }

    public function toString(): string
    {
        return $this->type;
    }

    public function equals(ItemType $type): bool
    {
        return $this->type === $type->toString();
    }
}
