<?php

use App\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->delete();

        $locations = [
            [
                "id"            => 1,
                "name"          => "Human Barracks",
                "description"   => "Facility where humans train their new recruits (Starting location)"
            ],
            [
                "id"            => 2,
                "name"          => "Elf Academy",
                "description"   => "Facility where elfs train their new recruits (Starting location)"
            ],
            [
                "id"            => 3,
                "name"          => "Dwarf Forge",
                "description"   => "Facility where dwarfs train their new recruits (Starting location)"
            ],
            [
                "id"            => 4,
                "name"          => "Orc Hatchery",
                "description"   => "Facility where orcs train their new recruits (Starting location)"
            ],
        ];

        foreach ($locations as $location)
        {
            Location::create($location);
        }
    }
}
