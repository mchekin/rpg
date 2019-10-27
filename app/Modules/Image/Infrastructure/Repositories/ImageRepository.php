<?php

namespace App\Modules\Image\Infrastructure\Repositories;

use App\Modules\Image\Domain\ValueObjects\ImageFile;
use App\Modules\Image\Domain\Entities\Image;
use App\Image as ImageModel;
use App\Modules\Image\Domain\Contracts\ImageRepositoryInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
use Intervention\Image\Image as ImageManagerFile;

class ImageRepository implements ImageRepositoryInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var ImageManager
     */
    private $imageManager;

    public function __construct(Filesystem $filesystem, ImageManager $imageManager)
    {
        $this->filesystem = $filesystem;
        $this->imageManager = $imageManager;
    }

    public function add(Image $image, UploadedFile $uploadedFile)
    {
        $urlPath = $this->getUrlPath($image->getCharacterId());

        $this->writeFiles($image, $uploadedFile);

        return ImageModel::query()->create([
            'id' => $image->getId(),
            'character_id' => $image->getCharacterId(),
            'file_path_full' => $urlPath . $image->getFullSizeFile()->getFileName(),
            'file_path_small' => $urlPath . $image->getSmallSizeFile()->getFileName(),
            'file_path_icon' => $urlPath . $image->getIconSizeFile()->getFileName(),
        ]);
    }

    public function delete(string $characterId)
    {
        $this->filesystem->deleteDirectory($this->getFolderPath($characterId));

        ImageModel::query()->where('character_id', '=', $characterId)->delete();
    }

    public function getOne($id): Image
    {
        /** @var ImageModel $imageModel */
        $imageModel = ImageModel::query()->findOrFail($id);

        return new Image(
            $imageModel->getId(),
            $imageModel->getCharacterId(),
            ImageFile::full($imageModel->getFilePathFull()),
            ImageFile::small($imageModel->getFilePathSmall()),
            ImageFile::icon($imageModel->getFilePathIcon())
        );
    }

    private function writeFiles(Image $image, UploadedFile $uploadedFile)
    {
        $folderPath = $this->getFolderPath($image->getCharacterId());

        $this->createFolderIfMissing($folderPath);

        $imageFile = $this->imageManager->make($uploadedFile);

        $this->writeFile($image->getFullSizeFile(), $folderPath, $imageFile);
        $this->writeFile($image->getSmallSizeFile(), $folderPath, $imageFile);
        $this->writeFile($image->getIconSizeFile(), $folderPath, $imageFile);
    }

    private function writeFile(
        ImageFile $imageFile,
        string $folderPath,
        ImageManagerFile $imageManagerFile
    )
    {
        $filePath = $folderPath . $imageFile->getFileName();

        $imageManagerFile
            ->resize($imageFile->getWidth(), null, function (Constraint $constraint) {
                $constraint->aspectRatio();
            })
            ->save($filePath);

        return $filePath;
    }

    private function createFolderIfMissing(string $fullFolderPath): bool
    {
        return $this->filesystem->exists($fullFolderPath)
            or $this->filesystem->makeDirectory($fullFolderPath, 0755, true);
    }

    private function getFolderPath(string $characterId): string
    {
        return storage_path(
            'app' . DIRECTORY_SEPARATOR
            . 'public' . DIRECTORY_SEPARATOR
            . $this->getCharacterImageFolder($characterId)
        );
    }

    private function getUrlPath(string $characterId): string
    {
        return 'storage' . DIRECTORY_SEPARATOR . $this->getCharacterImageFolder($characterId);
    }

    private function getCharacterImageFolder(string $characterId)
    {
        return 'images' . DIRECTORY_SEPARATOR
            . 'characters' . DIRECTORY_SEPARATOR
            . $characterId . DIRECTORY_SEPARATOR;
    }
}