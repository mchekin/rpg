<?php


namespace App\Modules\Level\Application\Services;

use App\Modules\Level\Domain\Level;

class LevelService
{
    public function getLevelByXp(int $xp): Level
    {
        $levelId = 1;

        while ($this->getLevelThreshold($levelId) < $xp) {
            $levelId++;
        }

        return $this->getLevel($levelId - 1);
    }

    public function getLevel(int $levelId): Level
    {
        return new Level($levelId, $this->getLevelThreshold($levelId), $this->getLevelThreshold($levelId + 1));
    }

    public function getLevels(int $limit = 100): array
    {
        $levelId = 1;

        $levels = [];
        while ($levelId <= $limit) {

            $levels[] = new Level(
                $levelId,
                $this->getLevelThreshold($levelId),
                $this->getLevelThreshold($levelId + 1)
            );

            $levelId++;
        }

        return $levels;
    }

    private function getLevelThreshold(int $levelId): float
    {
        $rawValue = 4 * ($levelId ** 3) / 5;

        return floor($rawValue);
    }
}
