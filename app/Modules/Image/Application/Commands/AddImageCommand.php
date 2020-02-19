<?php


namespace App\Modules\Image\Application\Commands;

use Illuminate\Http\UploadedFile;

class AddImageCommand
{
    /**
     * @var string
     */
    private $characterId;

    /**
     * @var UploadedFile
     */
    private $uploadedFile;

    public function __construct(string $characterId, UploadedFile $uploadedFile)
    {
        $this->characterId = $characterId;
        $this->uploadedFile = $uploadedFile;
    }

    public function getCharacterId(): string
    {
        return $this->characterId;
    }

    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }
}
