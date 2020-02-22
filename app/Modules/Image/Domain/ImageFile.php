<?php


namespace App\Modules\Image\Domain;

class ImageFile
{
    public const IMAGE_WIDTH_FULL = 1000;
    public const IMAGE_WIDTH_SMALL = 100;
    public const IMAGE_WIDTH_ICON = 20;

    /**
     * @var string
     */
    private $fileName;
    /**
     * @var int
     */
    private $width;

    private function __construct(string $fileName, int $width)
    {
        $this->fileName = $fileName;
        $this->width = $width;
    }

    public static function full(string $fileName): self
    {
        return new self($fileName, self::IMAGE_WIDTH_FULL);
    }

    public static function small(string $fileName): self
    {
        return new self($fileName, self::IMAGE_WIDTH_SMALL);
    }

    public static function icon(string $fileName): self
    {
        return new self($fileName, self::IMAGE_WIDTH_ICON);
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getWidth(): int
    {
        return $this->width;
    }
}
