<?php


namespace App\Modules\Character\Domain\Services;


use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Domain\Factories\CharacterFactory;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\Requests\CreateCharacterRequest;
use App\Modules\Character\Domain\Requests\IncreaseAttributeRequest;
use App\Modules\Character\Domain\Requests\MoveCharacterRequest;

class CharacterService
{
    /**
     * @var CharacterFactory
     */
    private $characterFactory;
    /**
     * @var CharacterRepositoryInterface
     */
    private $characterRepository;

    public function __construct(
        CharacterFactory $characterFactory,
        CharacterRepositoryInterface $characterRepository
    ) {
        $this->characterFactory = $characterFactory;
        $this->characterRepository = $characterRepository;
    }

    public function create(CreateCharacterRequest $request): Character
    {
        $character = $this->characterFactory->create($request);

        $this->characterRepository->add($character);

        return $character;
    }

    public function getOne(string $characterId): Character
    {
        return $this->characterRepository->getOne($characterId);
    }

    public function increaseAttribute(IncreaseAttributeRequest $request)
    {
        $character = $this->characterRepository->getOne($request->getCharacterId());

        $character->applyAttributeIncrease($request->getAttribute());

        $this->characterRepository->update($character);
    }

    public function move(MoveCharacterRequest $moveCharacterRequest)
    {
        $character = $this->characterRepository->getOne($moveCharacterRequest->getCharacterId());

        $character->setLocationId($moveCharacterRequest->getLocationId());

        $this->characterRepository->update($character);
    }
}