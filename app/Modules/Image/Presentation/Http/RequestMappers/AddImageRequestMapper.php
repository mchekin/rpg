<?php


namespace App\Modules\Image\Presentation\Http\RequestMappers;

use App\Modules\Image\Domain\Requests\AddImageRequest;
use Illuminate\Http\UploadedFile;

class AddImageRequestMapper
{
    public function map(string $characterId, UploadedFile $uploadedFile): AddImageRequest
    {
        return new AddImageRequest($characterId, $uploadedFile);
    }
}