<?php

namespace App\Modules\Character\Infrastructure\Repositories;

use App\Modules\Character\Domain\Contracts\LocationRepositoryInterface;
use App\Modules\Character\Domain\Entities\Location;
use Doctrine\ORM\EntityManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LocationRepository implements LocationRepositoryInterface
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
     * @param string $id
     *
     * @return Location
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getOne(string $id): Location
    {
        /** @var Location $location */
        $location = $this->entityManager->find(Location::class, $id);

        if (is_null($location))
        {
            throw new ModelNotFoundException();
        }

        return $location;
    }
}
