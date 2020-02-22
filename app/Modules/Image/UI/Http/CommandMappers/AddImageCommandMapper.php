<?php


namespace App\Modules\Image\UI\Http\CommandMappers;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Image\Application\Commands\AddImageCommand;
use Illuminate\Http\UploadedFile;

class AddImageCommandMapper
{
    public function map(string $characterId, UploadedFile $uploadedFile): AddImageCommand
    {
        return new AddImageCommand(
            CharacterId::fromString($characterId),
            $uploadedFile
        );
    }
}
