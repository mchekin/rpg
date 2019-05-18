<?php

namespace App\Http\Controllers;

use App\Character;
use App\Http\Requests\UploadImageRequest;
use App\Modules\Image\Domain\Services\ProfilePictureService;
use App\Modules\Image\Presentation\Http\CommandMappers\AddImageCommandMapper;

class ProfilePictureController extends Controller
{
    public function __construct()
    {
        $this->middleware('owns.character');
    }

    public function store(
        Character $character,
        UploadImageRequest $request,
        ProfilePictureService $profilePictureService,
        AddImageCommandMapper $commandMapper
    ) {
        $addImageCommand = $commandMapper->map($character->getId(), $request->file('file'));

        $profilePictureService->update($addImageCommand);

        return back()->with('status', 'Profile picture has been changed');
    }

    public function destroy(
        Character $character,
        ProfilePictureService $profilePictureService
    ) {
        $profilePictureService->delete($character->getId());

        return back()->with('status', 'Profile picture has been deleted');
    }
}
