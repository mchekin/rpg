<?php

namespace App\Http\Controllers;

use App\Contracts\Models\CharacterInterface;
use App\Http\Requests\UploadImageRequest;
use App\Services\FilesystemService;

class ProfilePictureController extends Controller
{
    /**
     * CharacterController constructor.
     */
    public function __construct()
    {
        $this->middleware('owns.character');
    }

    public function store(CharacterInterface $character, UploadImageRequest $request, FilesystemService $filesystemService)
    {
        $imageFiles = $filesystemService->writeProfilePictureFiles($character, $request->file('file'));

        $character->addProfilePicture($imageFiles);

        return back()->with('status', 'Profile picture has been changed');
    }

    public function destroy(CharacterInterface $character, FilesystemService $filesystemService)
    {
        $filesystemService->deleteProfilePictureFiles($character);

        $character->deleteProfilePicture();

        return back()->with('status', 'Profile picture has been deleted');
    }
}
