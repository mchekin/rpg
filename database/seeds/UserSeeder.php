<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = [
            [
                "id"            => 1,
                "name"          => "Misha Chekin",
                "password"      => Hash::make("1234"),
                "email"         => "mchekin@gmail.com",
            ],
        ];

        foreach ($users as $user)
        {
           User::create($user);
        }
    }
}
