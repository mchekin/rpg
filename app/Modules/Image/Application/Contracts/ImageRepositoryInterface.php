<?php


namespace App\Modules\Image\Application\Contracts;


use App\Modules\Image\Domain\Image;
use Illuminate\Http\UploadedFile;

interface ImageRepositoryInterface
{
    public function add(Image $image, UploadedFile $uploadedFile): void;

    public function delete(string $characterId): void;

    public function getOne($id): Image;
}
