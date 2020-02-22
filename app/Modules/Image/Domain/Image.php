<?php

namespace App\Modules\Image\Domain;

class Image
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $characterId;
    /**
     * @var ImageFile
     */
    private $fullSizeFile;
    /**
     * @var ImageFile
     */
    private $smallSizeFile;
    /**
     * @var ImageFile
     */
    private $iconSizeFile;

    public function __construct(
        string $id,
        string $characterId,
        ImageFile $fullSizeFile,
        ImageFile $smallSizeFile,
        ImageFile $iconSizeFile
    ) {
        $this->id = $id;
        $this->characterId = $characterId;
        $this->fullSizeFile = $fullSizeFile;
        $this->smallSizeFile = $smallSizeFile;
        $this->iconSizeFile = $iconSizeFile;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCharacterId(): string
    {
        return $this->characterId;
    }

    public function getFullSizeFile(): ImageFile
    {
        return $this->fullSizeFile;
    }

    public function getSmallSizeFile(): ImageFile
    {
        return $this->smallSizeFile;
    }

    public function getIconSizeFile(): ImageFile
    {
        return $this->iconSizeFile;
    }
}
