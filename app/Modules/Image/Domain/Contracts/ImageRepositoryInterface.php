<?php


namespace App\Modules\Image\Domain\Contracts;


use App\Modules\Image\Domain\Entities\Image;
use Illuminate\Http\UploadedFile;

interface ImageRepositoryInterface
{
    public function add(Image $image, UploadedFile $uploadedFile);

    public function delete(string $characterId);
}