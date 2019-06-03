<?php


namespace App\Modules\Image\Domain\Services;

use App\Modules\Character\Domain\Services\CharacterService;
use App\Modules\Image\Domain\Contracts\ImageRepositoryInterface;
use App\Modules\Image\Domain\Factories\ImageFactory;
use App\Modules\Image\Domain\Commands\AddImageCommand;

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

    public function update(AddImageCommand $command)
    {
        $profilePicture = $this->imageFactory->create(
            $command->getCharacterId(),
            $command->getUploadedFile()->getClientOriginalExtension()
        );

        $this->imageRepository->delete($command->getCharacterId());

        $this->imageRepository->add($profilePicture, $command->getUploadedFile());

        $this->characterService->updateProfilePicture($profilePicture);
    }

    public function delete(string $characterId)
    {
        $this->imageRepository->delete($characterId);

        $this->characterService->removeProfilePicture($characterId);
    }
}