<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Traits\Seedable;

class VoyagerDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__.'/';

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->seed(DataTypesTableSeeder::class);
        $this->seed(DataRowsTableSeeder::class);
        $this->seed(MenusTableSeeder::class);
        $this->seed(MenuItemsTableSeeder::class);
        $this->seed(RolesTableSeeder::class);
        $this->seed(PermissionsTableSeeder::class);
        $this->seed(PermissionRoleTableSeeder::class);
        $this->seed(SettingsTableSeeder::class);
    }
}
