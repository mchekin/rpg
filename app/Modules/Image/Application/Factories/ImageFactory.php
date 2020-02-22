<?php


namespace App\Modules\Image\Application\Factories;


use App\Modules\Character\Domain\CharacterId;
use App\Modules\Image\Domain\ImageFile;
use App\Modules\Image\Domain\Image;
use App\Traits\GeneratesUuid;

class ImageFactory
{
    use GeneratesUuid;

    public function create(CharacterId $characterId, string $extension): Image
    {
        $id = $this->generateUuid();

        $fileName = $id . '.' . $extension;

        return new Image(
            $id,
            $characterId,
            ImageFile::full('full_' . $fileName),
            ImageFile::small('small_' . $fileName),
            ImageFile::icon('icon_' . $fileName)
        );
    }
}
