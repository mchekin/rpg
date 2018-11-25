<?php

namespace App\Http\Controllers;

use App\Contracts\Models\UserInterface;
use App\Http\Requests\UploadImageRequest;
use App\Services\FilesystemService;

class ImageController extends Controller
{
    public function store(UploadImageRequest $request, FilesystemService $filesystemService)
    {
        /** @var UserInterface $authenticatedUser */
        $authenticatedUser = $request->user();
        $character = $authenticatedUser->getCharacter();

        $imageFile = $filesystemService->writeImage($request->file('file'));

        $character->addProfilePicture(
            'storage'. DIRECTORY_SEPARATOR
            . 'images' .DIRECTORY_SEPARATOR
            . $imageFile->basename
        );

        return back()->with('status', 'Profile picture has been changed');

    }
}
