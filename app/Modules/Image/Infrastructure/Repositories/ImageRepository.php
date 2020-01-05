<?php

namespace App\Modules\Image\Infrastructure\Repositories;

use App\Modules\Image\Domain\ValueObjects\ImageFile;
use App\Modules\Image\Domain\Entities\Image;
use App\Image as ImageModel;
use App\Modules\Image\Domain\Contracts\ImageRepositoryInterface;
use Doctrine\ORM\EntityManager;
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
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(Filesystem $filesystem, ImageManager $imageManager, EntityManager $entityManager)
    {
        $this->filesystem = $filesystem;
        $this->imageManager = $imageManager;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Image $image
     * @param UploadedFile $uploadedFile
     * @throws \Doctrine\ORM\ORMException
     */
    public function add(Image $image, UploadedFile $uploadedFile): void
    {
        $urlPath = $this->getUrlPath($image->getCharacter()->getId());

        $this->writeFiles($image, $uploadedFile);

        $this->entityManager->persist($image);
    }

    public function delete(string $characterId): void
    {
        $this->filesystem->deleteDirectory($this->getFolderPath($characterId));

        ImageModel::query()->where('character_id', '=', $characterId)->delete();
    }

    /**
     * @param $id
     * @return Image
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getOne($id): Image
    {
        /** @var Image $image */
        $image = $this->entityManager->find(Image::class, $id);

        return $image;
    }

    private function writeFiles(Image $image, UploadedFile $uploadedFile)
    {
        $folderPath = $this->getFolderPath($image->getCharacter()->getId());

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
