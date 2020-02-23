<?php

namespace App\Modules\Image\Domain;

use App\Modules\Character\Domain\CharacterId;

class Image
{
    /**
     * @var ImageId
     */
    private $id;
    /**
     * @var CharacterId
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
        ImageId $id,
        CharacterId $characterId,
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

    public function getId(): ImageId
    {
        return $this->id;
    }

    public function getCharacterId(): CharacterId
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
