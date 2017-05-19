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
                "next_level_xp_threshold"  => 5,
            ],
            [
                "id"            => 2,
                "next_level_xp_threshold"  => 10,
            ],
            [
                "id"            => 3,
                "next_level_xp_threshold"  => 20,
            ],
            [
                "id"            => 4,
                "next_level_xp_threshold"  => 40,
            ],
            [
                "id"            => 5,
                "next_level_xp_threshold"  => 80,
            ],
            [
                "id"            => 6,
                "next_level_xp_threshold"  => 160,
            ],
            [
                "id"            => 7,
                "next_level_xp_threshold"  => 320,
            ],
            [
                "id"            => 8,
                "next_level_xp_threshold"  => 640,
            ],
            [
                "id"            => 9,
                "next_level_xp_threshold"  => 1280,
            ],
            [
                "id"            => 10,
                "next_level_xp_threshold"  => 2560,
            ],
            [
                "id"            => 11,
                "next_level_xp_threshold"  => 5120,
            ],
            [
                "id"            => 12,
                "next_level_xp_threshold"  => 10240,
            ],
        ];

        foreach ($levels as $level)
        {
            Level::query()->create($level);
        }
    }
}
