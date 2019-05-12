<?php


namespace App\Modules\Image\Domain\Factories;


use App\Modules\Image\Domain\Entities\ImageFile;
use App\Modules\Image\Domain\Entities\Image;
use App\Traits\GeneratesUuid;

class ImageFactory
{
    use GeneratesUuid;

    const IMAGE_WIDTH_FULL = 1000;
    const IMAGE_WIDTH_SMALL = 100;
    const IMAGE_WIDTH_ICON = 20;

    public function create(string $characterId): Image
    {
        $id = $this->generateUuid();

        return new Image(
            $id,
            $characterId,
            new ImageFile('full_' . $id->toString(), self::IMAGE_WIDTH_FULL),
            new ImageFile('small_' . $id->toString(), self::IMAGE_WIDTH_FULL),
            new ImageFile('icon_' . $id->toString(), self::IMAGE_WIDTH_FULL)
        );
    }
}