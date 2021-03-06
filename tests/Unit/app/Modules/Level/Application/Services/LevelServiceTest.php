<?php


namespace Tests\Unit\App\Modules\Level\Application\Services;

use App\Modules\Level\Domain\Level;
use App\Modules\Level\Application\Services\LevelService;
use Tests\TestCase;

class LevelServiceTest extends TestCase
{
    /** @var LevelService */
    private $levelService;

    protected function setUp():void
    {
        parent::setUp();

        $this->levelService = new LevelService();
    }

    public function xpForLevelServiceProvider()
    {
        $levels = (new LevelService())->getLevels(10);

        $levelMiddlePoints = array_map(static function (Level $level) {
            $middlePoint = floor(($level->getCurrentXpThreshold() + $level->getNextXpThreshold()) / 2);

            return [
                'xp' => (int)$middlePoint,
                'levelId' => $level->getId(),
            ];

        }, $levels);

        return $levelMiddlePoints;
    }

    /**
     * @dataProvider xpForLevelServiceProvider
     *
     * @param int $xp
     * @param int $levelId
     */
    public function testGetLevelByXp(int $xp, int $levelId): void
    {
        $level = $this->levelService->getLevelByXp($xp);

        $this->assertEquals($levelId, $level->getId());
    }
}
