<?php declare(strict_types=1);


namespace App\Modules\Generic\Domain;


use InvalidArgumentException;

class ContainerType
{
    private const VALID_TYPES = [
        self::INVENTORY,
        self::STORE
    ];

    private const INVENTORY = 'inventory';
    private const STORE = 'store';

    /**
     * @var string
     */
    private $type;

    public static function fromString(string $type)
    {
        return new static($type);
    }

    private function __construct(string $type)
    {
        if (!in_array($type, self::VALID_TYPES, true)) {
            throw new InvalidArgumentException('Invalid showContainer type: ' . $type);
        }

        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isStore(): bool
    {
        return $this->type === self::STORE;
    }
}
