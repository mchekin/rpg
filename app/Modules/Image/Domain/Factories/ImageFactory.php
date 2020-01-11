<?php


namespace App\Modules\Image\Domain\Factories;


use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Image\Domain\Entities\Image;
use App\Traits\GeneratesUuid;

class ImageFactory
{
    use GeneratesUuid;

    public function create(Character $character, string $folderUrl, string $extension): Image
    {
        $id = $this->generateUuid();

        $fileName = $id . '.' . $extension;

        return new Image(
            $id,
            $character,
            $folderUrl. 'full_' . $fileName,
            $folderUrl. 'small_' . $fileName,
            $folderUrl.'icon_' . $fileName
        );
    }
}
