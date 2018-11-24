<?php

namespace App\Http\Controllers;

use App\Contracts\Models\UserInterface;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function store(Request $request, ImageService $imageService)
    {
        $this->validate($request, [
            'filename' => 'image|required'
        ]);

        $originalImage = $request->file('filename');

        /** @var \Intervention\Image\Image $thumbnailImage */
        $thumbnailImage = Image::make($originalImage);

        $imagesFolder = storage_path(
            'app' . DIRECTORY_SEPARATOR
            . 'public' . DIRECTORY_SEPARATOR
            . 'images' . DIRECTORY_SEPARATOR
        );

        $fileName = time() . $originalImage->getClientOriginalName();

        /** @var UserInterface $authenticatedUser */
        $authenticatedUser = $request->user();

        $character = $authenticatedUser->getCharacter();

        $thumbnailImage
            ->resize(400, null, function (Constraint $constraint) {
                $constraint->aspectRatio();
            })
            ->save($imagesFolder . $fileName);

        $character->addProfilePicture(
            'storage'. DIRECTORY_SEPARATOR
            . 'images' .DIRECTORY_SEPARATOR
            . $fileName
        );

        return back()->with('success', 'Your images has been successfully Upload');

    }
}
