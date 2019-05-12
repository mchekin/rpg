<?php


namespace App\Modules\Level\Infrastructure\ReconstitutionFactories;

use App\Level as LevelModel;
use App\Modules\Level\Domain\Entities\Level;


class LevelReconstitutionFactory
{
    public function reconstitute(LevelModel $levelModel): Level
    {
        return new Level(
            $levelModel->getId(),
            $levelModel->getNextLevelXpThreshold()
        );
    }
}