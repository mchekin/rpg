<?php


namespace App\Modules\Level\Domain\Services;

use App\Modules\Level\Domain\Contracts\LevelRepositoryInterface;
use App\Modules\Level\Domain\Entities\Level;

class LevelService
{
    /**
     * @var LevelRepositoryInterface
     */
    private $levelRepository;

    public function __construct(LevelRepositoryInterface $levelRepository)
    {
        $this->levelRepository = $levelRepository;
    }

    public function getOne(string $characterId): Level
    {
        return $this->levelRepository->getOne($characterId);
    }

    public function getLevelByXp(int $xp): Level
    {
        return $this->levelRepository->getLevelByXp($xp);
    }
}