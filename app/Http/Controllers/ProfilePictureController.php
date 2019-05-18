<?php

namespace App\Http\Controllers;

use App\Character;
use App\Http\Requests\UploadImageRequest;
use App\Modules\Image\Domain\Services\ProfilePictureService;
use App\Modules\Image\Presentation\Http\RequestMappers\AddImageRequestMapper;

class ProfilePictureController extends Controller
{
    /**
     * CharacterController constructor.
     */
    public function __construct()
    {
        $this->middleware('owns.character');
    }

    public function store(
        Character $character,
        UploadImageRequest $request,
        ProfilePictureService $profilePictureService,
        AddImageRequestMapper $requestMapper
    ) {
        $addImageRequest = $requestMapper->map($character->getId(), $request->file('file'));

        $profilePictureService->update($addImageRequest);

        return back()->with('status', _t('Profile picture has been changed'));
    }

    public function destroy(
        Character $character,
        ProfilePictureService $profilePictureService
    ) {
        $profilePictureService->delete($character->getId());

        return back()->with('status', _t('Profile picture has been deleted'));
    }
}
