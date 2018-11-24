<?php

namespace App\Services;

use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image as ImageFacade;
use Intervention\Image\Image as ImageFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilesystemService
{
    public function writeImage(UploadedFile $originalImage): ImageFile
    {
        /** @var ImageFile $image */
        $image = ImageFacade::make($originalImage);

        $imagesFolder = storage_path(
            'app' . DIRECTORY_SEPARATOR
            . 'public' . DIRECTORY_SEPARATOR
            . 'images' . DIRECTORY_SEPARATOR
        );

        $fileName = time() . $originalImage->getClientOriginalName();

        return $image
            ->resize(400, null, function (Constraint $constraint) {
                $constraint->aspectRatio();
            })
            ->save($imagesFolder . $fileName);
    }
}