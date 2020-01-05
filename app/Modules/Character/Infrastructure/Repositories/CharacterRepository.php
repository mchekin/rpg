<?php

namespace App\Modules\Character\Infrastructure\Repositories;

use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Domain\Entities\Character;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CharacterRepository implements CharacterRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Character $character
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function add(Character $character): void
    {
        $this->entityManager->persist($character);
    }

    /**
     * @param string $characterId
     * @return Character
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getOne(string $characterId): Character
    {
        /** @var Character $character */
        $character = $this->entityManager->find(Character::class, $characterId);

        if (is_null($character))
        {
            throw new ModelNotFoundException();
        }

        return $character;
    }
}
