<?php


namespace App\Modules\Image\Domain\ValueObjects;

class ImageFile
{
    /**
     * @var string
     */
    private $fileName;
    /**
     * @var int
     */
    private $width;

    public function __construct(string $fileName, int $width)
    {
        $this->fileName = $fileName;
        $this->width = $width;
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