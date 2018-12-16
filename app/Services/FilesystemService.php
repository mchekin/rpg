<?php

namespace App\Services;

use App\Contracts\Models\UserInterface;
use App\Services\FilesystemService\ImageFiles;
use Illuminate\Support\Facades\File;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image as ImageFacade;
use Intervention\Image\Image as ImageFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilesystemService
{
    const IMAGE_WIDTH_FULL = 1000;
    const IMAGE_WIDTH_SMALL = 100;
    const IMAGE_WIDTH_ICON = 20;

    const AVAILABLE_IMAGE_WIDTHS = [
        'full' => self::IMAGE_WIDTH_FULL,
        'small' => self::IMAGE_WIDTH_SMALL,
        'icon' => self::IMAGE_WIDTH_ICON,
    ];

    const USERS_IMAGES_FOLDER = 'images' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR;

    public function writeImage(UploadedFile $originalImage, UserInterface $user): ImageFiles
    {
        $fullStorageFolderPath = storage_path(
            'app' . DIRECTORY_SEPARATOR
            . 'public' . DIRECTORY_SEPARATOR
            . self::USERS_IMAGES_FOLDER
            . $user->getId() . DIRECTORY_SEPARATOR
        );

        $urlPath = 'storage' . DIRECTORY_SEPARATOR
            . self::USERS_IMAGES_FOLDER
            . $user->getId() . DIRECTORY_SEPARATOR;

        // creating directory if not exists
        File::exists($fullStorageFolderPath) or File::makeDirectory($fullStorageFolderPath);

        $fileName = time() . $originalImage->getClientOriginalName();

        $imageFiles = new ImageFiles($urlPath);

        foreach (static::AVAILABLE_IMAGE_WIDTHS as $key => $imageWidth) {
            /** @var ImageFile $image */
            $image = ImageFacade::make($originalImage);

            $image
                ->resize($imageWidth, null, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                })
                ->save($fullStorageFolderPath . '_' . $key . '_' . $fileName );

            $imageFiles->addImageFile($key, $image);
        }

        return $imageFiles;
    }
}