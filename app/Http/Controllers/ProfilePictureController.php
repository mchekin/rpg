<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use App\Modules\Image\Application\Services\ProfilePictureService;
use App\Modules\Image\UI\Http\CommandMappers\AddImageCommandMapper;

class ProfilePictureController extends Controller
{
    public function __construct()
    {
        $this->middleware('owns.character');
    }

    public function store(
        string $characterId,
        UploadImageRequest $request,
        ProfilePictureService $profilePictureService,
        AddImageCommandMapper $commandMapper
    ) {
        $addImageCommand = $commandMapper->map($characterId, $request->file('file'));

        $profilePictureService->update($addImageCommand);

        return back()->with('status', 'Profile picture has been changed');
    }

    public function destroy(
        string $characterId,
        ProfilePictureService $profilePictureService
    ) {
        $profilePictureService->delete($characterId);

        return back()->with('status', 'Profile picture has been deleted');
    }
}
