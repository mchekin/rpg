<?php


namespace App\Modules\Image\Application\Commands;

use App\Modules\Character\Domain\CharacterId;
use Illuminate\Http\UploadedFile;

class AddImageCommand
{
    /**
     * @var CharacterId
     */
    private $characterId;

    /**
     * @var UploadedFile
     */
    private $uploadedFile;

    public function __construct(CharacterId $characterId, UploadedFile $uploadedFile)
    {
        $this->characterId = $characterId;
        $this->uploadedFile = $uploadedFile;
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }

    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }
}
