<?php


namespace App\Modules\Image\Application\Factories;


use App\Modules\Image\Domain\ValueObjects\ImageFile;
use App\Modules\Image\Domain\Entities\Image;
use App\Traits\GeneratesUuid;

class ImageFactory
{
    use GeneratesUuid;

    public function create(string $characterId, string $extension): Image
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
