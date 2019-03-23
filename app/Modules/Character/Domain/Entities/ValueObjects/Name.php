<?php


namespace App\Modules\Character\Domain\Entities\ValueObjects;


class Name
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(Name $otherName): bool
    {
        return $this->value === $otherName->value;
    }
}