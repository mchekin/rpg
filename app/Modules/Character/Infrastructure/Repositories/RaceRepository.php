<?php

namespace App\Modules\Character\Infrastructure\Repositories;

use App\Modules\Character\Domain\Contracts\RaceRepositoryInterface;
use App\Modules\Character\Domain\Entities\Race;
use Doctrine\ORM\EntityManager;

class RaceRepository implements RaceRepositoryInterface
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
     * @param int $raceId
     *
     * @return Race
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getOne(int $raceId): Race
    {
        /** @var Race $race */
        $race = $this->entityManager->find(Race::class, $raceId);

        return $race;
    }
}
