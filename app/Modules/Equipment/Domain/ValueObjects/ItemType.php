<?php

namespace App\Modules\Equipment\Domain\ValueObjects;

use InvalidArgumentException;

class ItemType
{
    const MISCELLANEOUS = 'miscellaneous';
    const HEAD_GEAR = 'head_gear';
    const BODY_ARMOR = 'body_armor';
    const MAIN_HAND = 'main_hand';
    const OFF_HAND = 'off_hand';

    const TYPES = [
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

    public static function ofType(string $type)
    {
        if (!in_array($type, self::TYPES, true)) {
            throw new InvalidArgumentException("$type is not a valid Item Type");
        }

        return new self($type);
    }

    public static function headGear()
    {
        return new self(self::HEAD_GEAR);
    }

    public static function bodyArmor()
    {
        return new self(self::BODY_ARMOR);
    }

    public static function mainHand()
    {
        return new self(self::MAIN_HAND);
    }

    public static function offHand()
    {
        return new self(self::OFF_HAND);
    }

    public function toString(): string
    {
        return $this->type;
    }

    public function equals(ItemType $type)
    {
        return $this->type === $type->toString();
    }

}