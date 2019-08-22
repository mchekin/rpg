<?php

namespace App\Modules\Equipment\Domain\ValueObjects;

class ItemType
{
    const HEAD_GEAR = 'head_gear';
    const BODY_ARMOR = 'body_armor';
    const MAIN_HAND = 'main_hand';
    const OFF_HAND = 'off_hand';

    /**
     * @var string
     */
    private $type;

    private function __construct(string $type)
    {
        $this->type = $type;
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

    public function getType(): string
    {
        return $this->type;
    }

}