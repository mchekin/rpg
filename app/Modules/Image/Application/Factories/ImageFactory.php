<?php


namespace App\Modules\Image\Application\Factories;


use App\Modules\Character\Domain\CharacterId;
use App\Modules\Image\Domain\ImageFile;
use App\Modules\Image\Domain\Image;
use App\Modules\Image\Domain\ImageId;

class ImageFactory
{
    public function create(ImageId $imageId, CharacterId $characterId, string $extension): Image
    {
        $fileName = $imageId->toString() . '.' . $extension;

        return new Image(
            $imageId,
            $characterId,
            ImageFile::full('full_' . $fileName),
            ImageFile::small('small_' . $fileName),
            ImageFile::icon('icon_' . $fileName)
        );
    }
}
