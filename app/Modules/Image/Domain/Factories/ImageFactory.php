<?php


namespace App\Modules\Image\Domain\Factories;


use App\Modules\Image\Domain\ValueObjects\ImageFile;
use App\Modules\Image\Domain\Entities\Image;
use App\Traits\GeneratesUuid;

class ImageFactory
{
    use GeneratesUuid;

    const IMAGE_WIDTH_FULL = 1000;
    const IMAGE_WIDTH_SMALL = 100;
    const IMAGE_WIDTH_ICON = 20;

    public function create(string $characterId, string $extension): Image
    {
        $id = $this->generateUuid();

        $fileName = $id->toString() . '.' . $extension;

        return new Image(
            $id,
            $characterId,
            new ImageFile('full_' . $fileName, self::IMAGE_WIDTH_FULL),
            new ImageFile('small_' . $fileName, self::IMAGE_WIDTH_SMALL),
            new ImageFile('icon_' . $fileName, self::IMAGE_WIDTH_ICON)
        );
    }
}