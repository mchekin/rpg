<?php


namespace App\Modules\Image\Application\Services;

use App\Modules\Character\Application\Services\CharacterService;
use App\Modules\Character\Domain\CharacterId;
use App\Modules\Image\Application\Contracts\ImageRepositoryInterface;
use App\Modules\Image\Application\Factories\ImageFactory;
use App\Modules\Image\Application\Commands\AddImageCommand;

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

    public function update(AddImageCommand $command): void
    {
        $imageId = $this->imageRepository->nextIdentity();

        $profilePicture = $this->imageFactory->create(
            $imageId,
            $command->getCharacterId(),
            $command->getUploadedFile()->getClientOriginalExtension()
        );

        $this->imageRepository->delete($command->getCharacterId());

        $this->imageRepository->add($profilePicture, $command->getUploadedFile());

        $this->characterService->updateProfilePicture($profilePicture);
    }

    public function delete(CharacterId $characterId): void
    {
        $this->imageRepository->delete($characterId);

        $this->characterService->removeProfilePicture($characterId);
    }
}
