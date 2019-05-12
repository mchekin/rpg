<?php

namespace App\Modules\Level\Infrastructure\Repositories;


use App\Modules\Level\Domain\Contracts\LevelRepositoryInterface;
use App\Modules\Level\Domain\Entities\Level;
use App\Modules\Level\Infrastructure\ReconstitutionFactories\LevelReconstitutionFactory;
use App\Level as LevelModel;

class LevelRepository implements LevelRepositoryInterface
{
    /**
     * @var LevelReconstitutionFactory
     */
    private $reconstitutionFactory;

    public function __construct(LevelReconstitutionFactory $reconstitutionFactory)
    {
        $this->reconstitutionFactory = $reconstitutionFactory;
    }

    public function getOne(int $levelId): Level
    {
        /** @var LevelModel $levelModel */
        $levelModel = LevelModel::query()->findOrFail($levelId);

        return $this->reconstitutionFactory->reconstitute($levelModel);
    }

    public function getLevelByXp(int $xp): Level
    {
        /** @var LevelModel $levelModel */
        $levelModel = LevelModel::query()
            ->orderBy('id')
            ->where('next_level_xp_threshold', '>', $xp)
            ->first();

        if (is_null($levelModel)) {
            $levelModel = $this->getLastLevelModel();
        }

        return $this->reconstitutionFactory->reconstitute($levelModel);
    }

    /**
     * @return LevelModel
     */
    private function getLastLevelModel(): LevelModel
    {
        /** @var LevelModel $levelModel */
        $levelModel = LevelModel::query()
            ->orderBy('id', 'desc')
            ->firstOrFail();

        return $levelModel;
    }
}