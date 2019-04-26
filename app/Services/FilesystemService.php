<?php

namespace App\Services;

use App\Character;
use App\Services\FilesystemService\ImageFileCollectionFactory;
use App\Services\FilesystemService\ImageFileCollection;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
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

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * @var ImageFileCollectionFactory
     */
    private $fileCollectionFactory;

    public function __construct(
        Filesystem $filesystem,
        ImageManager $imageManager,
        ImageFileCollectionFactory $fileCollectionFactory
    ) {
        $this->filesystem = $filesystem;
        $this->imageManager = $imageManager;
        $this->fileCollectionFactory = $fileCollectionFactory;
    }

    const CHARACTER_IMAGE_FOLDER = 'images' . DIRECTORY_SEPARATOR . 'characters' . DIRECTORY_SEPARATOR;

    public function writeProfilePictureFiles(Character $character, UploadedFile $originalImage): ImageFileCollection
    {
        $fullFolderPath = $this->getFullFolderPath($character);
        $relativeFolderPath = $this->getRelativeFolderPath($character);

        $this->filesystem->deleteDirectory($fullFolderPath);

        $this->createFolderIfMissing($fullFolderPath);

        $imageFiles = $this->fileCollectionFactory->create($relativeFolderPath);

        $baseFileName = $this->generateBaseFileName($originalImage);

        foreach (static::AVAILABLE_IMAGE_WIDTHS as $key => $imageWidth) {

            $image = $this->imageManager->make($originalImage);

            $filePath = $fullFolderPath . '_' . $key . '_' . $baseFileName;

            $image
                ->resize($imageWidth, null, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                })
                ->save($filePath);

            $imageFiles->add($key, $image);
        }

        return $imageFiles;
    }

    public function deleteProfilePictureFiles(Character $character): bool
    {
        $fullFolderPath = $this->getFullFolderPath($character);

        return $this->filesystem->deleteDirectory($fullFolderPath);
    }

    private function getFullFolderPath(Character $character): string
    {
        return storage_path(
            'app' . DIRECTORY_SEPARATOR
            . 'public' . DIRECTORY_SEPARATOR
            . $this->getCharacterImageFolder($character)
        );
    }

    private function getRelativeFolderPath(Character $character): string
    {
        return 'storage' . DIRECTORY_SEPARATOR
            . $this->getCharacterImageFolder($character);
    }

    private function getCharacterImageFolder(Character $character): string
    {
        return self::CHARACTER_IMAGE_FOLDER . $character->getId() . DIRECTORY_SEPARATOR;
    }

    private function generateBaseFileName(UploadedFile $originalImage): string
    {
        return time() . $originalImage->getClientOriginalName();
    }

    private function createFolderIfMissing(string $fullFolderPath): bool
    {
        return $this->filesystem->exists($fullFolderPath)
            or $this->filesystem->makeDirectory($fullFolderPath);
    }
}