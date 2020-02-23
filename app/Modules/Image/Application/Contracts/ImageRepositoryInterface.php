<?php


namespace App\Modules\Image\Application\Contracts;


use App\Modules\Character\Domain\CharacterId;
use App\Modules\Image\Domain\Image;
use App\Modules\Image\Domain\ImageId;
use Illuminate\Http\UploadedFile;

interface ImageRepositoryInterface
{
    public function nextIdentity(): ImageId;

    public function add(Image $image, UploadedFile $uploadedFile): void;

    public function delete(CharacterId $characterId): void;
}
