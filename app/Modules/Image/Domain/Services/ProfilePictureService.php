<?php


namespace App\Modules\Image\Domain\Services;

use App\Modules\Character\Domain\Services\CharacterService;
use App\Modules\Image\Domain\Contracts\ImageRepositoryInterface;
use App\Modules\Image\Domain\Factories\ImageFactory;
use App\Modules\Image\Domain\Requests\AddImageRequest;

class ProfilePictureService
{
    /**
     * @var ImageFactory
     */
    private $imageFactory;
    /**
     * @var ImageRepositoryInterface
     */
    private $imageRepository;
    /**
     * @var CharacterService
     */
    private $characterService;

    public function __construct(
        ImageFactory $imageFactory,
        ImageRepositoryInterface $imageRepository,
        CharacterService $characterService
    ) {
        $this->imageFactory = $imageFactory;
        $this->imageRepository = $imageRepository;
        $this->characterService = $characterService;
    }

    public function update(AddImageRequest $request)
    {
        $profilePicture = $this->imageFactory->create(
            $request->getCharacterId()
        );

        $this->imageRepository->delete($request->getCharacterId());

        $this->imageRepository->add($profilePicture, $request->getUploadedFile());

        $this->characterService->updateProfilePicture($profilePicture);
    }

    public function delete(string $characterId)
    {
        $this->imageRepository->delete($characterId);

        $this->characterService->removeProfilePicture($characterId);
    }
}