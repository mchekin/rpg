<?php


namespace App\Modules\Image\Presentation\Http\CommandMappers;

use App\Modules\Image\Domain\Commands\AddImageCommand;
use Illuminate\Http\UploadedFile;

class AddImageCommandMapper
{
    public function map(string $characterId, UploadedFile $uploadedFile): AddImageCommand
    {
        return new AddImageCommand($characterId, $uploadedFile);
    }
}