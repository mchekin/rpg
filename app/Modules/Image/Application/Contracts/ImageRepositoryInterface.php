<?php


namespace App\Modules\Image\Application\Contracts;


use App\Modules\Character\Domain\CharacterId;
use App\Modules\Image\Domain\Image;
use Illuminate\Http\UploadedFile;

interface ImageRepositoryInterface
{
    public function add(Image $image, UploadedFile $uploadedFile): void;

    public function delete(CharacterId $characterId): void;

    public function getOne($id): Image;
}
