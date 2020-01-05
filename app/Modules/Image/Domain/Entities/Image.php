<?php

namespace App\Modules\Image\Domain\Entities;

use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Image\Domain\ValueObjects\ImageFile;
use Carbon\Carbon;

class Image
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var Character
     */
    private $character;
    /**
     * @var string
     */
    private $filePathFull;
    /**
     * @var string
     */
    private $filePathSmall;
    /**
     * @var string
     */
    private $filePathIcon;
    /**
     * @var Carbon
     */
    private $createdAt;
    /**
     * @var Carbon
     */
    private $updatedAt;

    public function __construct(
        string $id,
        Character $character,
        string $filePathFull,
        string $filePathSmall,
        string $filePathIcon
    ) {
        $this->id = $id;
        $this->character = $character;
        $this->filePathFull = $filePathFull;
        $this->filePathSmall = $filePathSmall;
        $this->filePathIcon = $filePathIcon;
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getFullSizeFile(): ImageFile
    {
        return ImageFile::full($this->filePathFull);
    }

    public function getSmallSizeFile(): ImageFile
    {
        return ImageFile::small($this->filePathSmall);
    }

    public function getIconSizeFile(): ImageFile
    {
        return ImageFile::icon($this->filePathIcon);
    }
}
