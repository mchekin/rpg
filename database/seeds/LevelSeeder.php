<?php

use App\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->delete();

        $levels = [
            [
                "id"            => 1,
                "xp_threshold"  => 0,
            ],
            [
                "id"            => 2,
                "xp_threshold"  => 100,
            ],
            [
                "id"            => 3,
                "xp_threshold"  => 200,
            ],
            [
                "id"            => 4,
                "xp_threshold"  => 400,
            ],
            [
                "id"            => 5,
                "xp_threshold"  => 800,
            ],
            [
                "id"            => 6,
                "xp_threshold"  => 1600,
            ],
            [
                "id"            => 7,
                "xp_threshold"  => 3200,
            ],
            [
                "id"            => 8,
                "xp_threshold"  => 6400,
            ],
            [
                "id"            => 9,
                "xp_threshold"  => 12800,
            ],
            [
                "id"            => 10,
                "xp_threshold"  => 25600,
            ],
            [
                "id"            => 11,
                "xp_threshold"  => 51200,
            ],
            [
                "id"            => 12,
                "xp_threshold"  => 102400,
            ],
        ];

        foreach ($levels as $level)
        {
            Level::create($level);
        }
    }
}
