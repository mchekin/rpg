<?php declare(strict_types=1);

namespace App\Modules\Generic\Domain;

abstract class BaseId
{
    /**
     * @var string
     */
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $id
     *
     * @return static
     */
    public static function fromString(string $id)
    {
        return new static($id);
    }

    public function toString(): string
    {
        return $this->id;
    }
}
