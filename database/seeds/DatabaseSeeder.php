<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(RaceSeeder::class);
        $this->call(CharacterSeeder::class);

        Model::reguard();
    }
}
