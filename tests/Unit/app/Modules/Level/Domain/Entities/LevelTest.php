<?php


namespace Tests\Unit\App\Modules\Level\Domain\Entities;

use App\Modules\Level\Domain\Entities\Level;
use Tests\TestCase;

class LevelTest extends TestCase
{
    public function testGetProgress()
    {
        $level = new Level(1, 50, 100);

        $progress = $level->getProgress(75);

        $this->assertEquals(50, $progress);
    }

    public function testGetProgressWithXpNotInRange()
    {
        $level = new Level(1, 50, 100);

        $progress = $level->getProgress(5);

        $this->assertEquals(0, $progress);
    }
}